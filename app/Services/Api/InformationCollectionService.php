<?php


namespace App\Services\Api;


use App\HelperClasses\Traits\AppHelper;
use App\HelperClasses\Traits\AuthHelper;
use App\HelperClasses\Traits\StorageHelper;
use App\Models\District;
use App\Models\Document;
use App\Models\DocumentComment;
use App\Models\InformationCollection;
use App\Models\InformationComment;
use App\Models\InformationDocument;
use App\Models\InformationReceiver;
use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\MinistryOffices;
use App\Models\TemplateField;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;


class InformationCollectionService
{
    use AuthHelper, StorageHelper, AppHelper;

    /**
     * @var NotificationService
     */
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Create Information Collection
     *
     * @param string $title
     * @param string $type
     * @param string $description
     * @param int $templateId
     * @param $main_doc
     * @param $supporting_doc
     * @param array $document_type
     * @param array $ministryIds
     * @param array $lgIds
     * @param array $ministryOfficeIds
     * @param string $startDate
     * @param string $submissionDate
     * @param string $priority
     * @return mixed
     */
    public function createNew(string $title, string $type, string $description, int $templateId, $main_doc, $supporting_doc,
                              array $document_type, array $ministryIds, array $lgIds, array $ministryOfficeIds,
                              string $startDate, string $submissionDate, string $priority)
    {
        $informationCollection = InformationCollection::create([
            'title'                 => $title,
            'assigner_id'           => $this->getAuthId(),
            'type'                  => $type,
            'description'           => $description,
            'template_id'           => $templateId !== 0 ? $templateId : null,
            'main_doc'              => '',
            'main_doc_path'         => '',
            'supporting_doc'        => null,
            'supporting_doc_path'   => null,
            'document_type'         => json_encode($document_type),
            'start_date'            => ($startDate != '' ? $startDate : date('Y-m-d')),
            'submission_date'       => ($submissionDate != '' ? $submissionDate : null),
            'status'                => getProcessingStatus(),
            'priority'              => $priority,
        ]);

        $mainDoc = $this->storeToInformation($main_doc, $informationCollection->id);

        if ($supporting_doc)
        {
            $supporting_doc = $this->storeToInformation($supporting_doc, $informationCollection->id);
        }

        InformationCollection::where('id', $informationCollection->id)->update([
            'main_doc'              => $mainDoc['name'],
            'main_doc_path'         => $mainDoc['path'],
            'main_doc_type'         => $mainDoc['type'],
            'supporting_doc'        => isset($supporting_doc) ? $supporting_doc['name'] ?? '' : null,
            'supporting_doc_path'   => isset($supporting_doc) ? $supporting_doc['path'] ?? '' : null,
            'supporting_doc_type'   => isset($supporting_doc) ? $supporting_doc['type'] ?? '' : null,
        ]);


        if (in_array(request()->get('select_all'), selectAllInformationKeys())) {
            $selectBy = request()->get('select_all');

            // select all lg by district id
            if ($selectBy == selectAllLgByDistrictKey())
            {
                $dataIds = LocalGovernment::where('status', 1)
                    ->where('district_id', request()->get('district_id'))
                    ->get()
                    ->pluck('id')
                    ->toArray();
                $storeTo = 'local_government';
            }

            // select all lg by province id
            if ($selectBy == selectAllLgByProvinceKey())
            {
                $dataIds = LocalGovernment::where('status', 1)
                    ->where('province_id', request()->get('province_id'))
                    ->get()
                    ->pluck('id')
                    ->toArray();
                $storeTo = 'local_government';
            }

            //select all ministries by province id
            if ($selectBy == selectAllMinistryByProvince())
            {
                $dataIds = Ministry::where('province_id', request()->get('province_id'))
                    ->where('status', 1)
                    ->get()
                    ->pluck('id')
                    ->toArray();

                $storeTo = 'ministry';
            }

            //select ministry offices by province id
            if ($selectBy == selectAllMinistryOfficeByProvince())
            {
                $dataIds = MinistryOffices::where('ministries.province_id', request()->get('province_id'))
                    ->join('ministries', 'ministry_offices.ministry_id', 'ministries.id')
                    ->where('ministries.status', 1)
                    ->where('ministry_offices.status', 1)
                    ->get()
                    ->pluck('id')
                    ->toArray();
                $storeTo = 'ministry_office';
            }

            //select ministry offices by ministry id
            if ($selectBy == selectAllMinistryOfficeByMinistry())
            {
                $dataIds = MinistryOffices::where('ministry_id', request()->get('ministry_id'))
                    ->where('status', 1)
                    ->get()
                    ->pluck('id')
                    ->toArray();
                $storeTo = 'ministry_office';
            }

        } else {
            if (count($lgIds) > 0){
                $storeTo = 'local_government';
                $dataIds = array_unique($lgIds);
            }
            if (count($ministryIds) > 0){
                $storeTo = 'ministry';
                $dataIds = array_unique($ministryIds);
            }
            if (count($ministryOfficeIds) > 0){
                $storeTo = 'ministry_office';
                $dataIds = array_unique($ministryOfficeIds);
            }
        }

        InformationCollection::where('id', $informationCollection->id)->update([
            'agency_type' => $storeTo
        ]);

        $infoReceivers = array_map(function ($dataId) use ($storeTo, $informationCollection) {
            return [
                'information_id'=> $informationCollection->id,
                'ministry_id'   => ($storeTo == 'ministry') ? $dataId : null,
                'office_id'     => ($storeTo == 'ministry_office') ? $dataId : null,
                'lg_id'         => ($storeTo == 'local_government') ? $dataId : null,
                'status'        => getPendingStatus(),
            ];
        }, $dataIds);


        DB::table('info_receivers')->insert($infoReceivers);

        $this->notificationService->sendInformationNotification(
            (string) $storeTo,
            (array) $dataIds,
            (string) $title,
            (string) $description,
            (int) request()->get('to_mail'),
            (int) request()->get('to_sms')
        );

        return $informationCollection;
    }

    /**
     * Update Information Collection
     *
     * @param int $informationId
     * @param string $title
     * @param string $type
     * @param string $description
     * @param int $templateId
     * @param $main_doc
     * @param $supporting_doc
     * @param array $document_type
     * @param string $startDate
     * @param string $submissionDate
     * @param string $priority
     * @return mixed
     */
    public function updateOld(int $informationId, string $title, string $type, string $description, int $templateId, $main_doc, $supporting_doc,
                              array $document_type, string $startDate, string $submissionDate, string $priority)
    {
        InformationCollection::where('id', $informationId)->update([
            'title'                 => $title,
            'assigner_id'           => $this->getAuthId(),
            'type'                  => $type,
            'description'           => $description,
            'template_id'           => $templateId !== 0 ? $templateId : null,
            'supporting_doc'        => null,
            'supporting_doc_path'   => null,
            'document_type'         => json_encode($document_type),
            'start_date'            => $startDate,
            'submission_date'       => $submissionDate,
            'priority'              => $priority,
        ]);
        if ($main_doc){
            $mainDoc = $this->storeToInformation($main_doc, $informationId);

            DB::table('information_collection')->where('id', $informationId)->update([
                'main_doc'              => $mainDoc['name'],
                'main_doc_path'         => $mainDoc['path'],
                'main_doc_type'         => $mainDoc['type'],
            ]);
        }

        if ($supporting_doc){
            $supporting_doc = $this->storeToInformation($supporting_doc, $informationId);

            DB::table('information_collection')->where('id', $informationId)->update([
                'supporting_doc'        => $supporting_doc['name'],
                'supporting_doc_path'   => $supporting_doc['path'],
                'supporting_doc_type'   => $supporting_doc['type'],
            ]);
        }

        return InformationCollection::where('id', $informationId)->first();
    }


    /**
     * Get Information For Ministry Admin
     *
     * @return mixed
     */
    public function getInformationForMinistryAdmin()
    {
        $paginationNo = request()->has('pagination_no') ? request()->get('pagination_no') : 12;

        return InformationCollection::select('information_collection.id as information_id', 'information_collection.title','information_collection.type','information_collection.agency_type'
            ,'information_collection.template_id','information_collection.description','information_collection.main_doc','information_collection.main_doc_path',
            'information_collection.main_doc_type','information_collection.supporting_doc','information_collection.supporting_doc_path',
            'information_collection.supporting_doc_type','information_collection.document_type','information_collection.assigner_id',
            'information_collection.start_date','information_collection.submission_date','information_collection.status as information_status','information_collection.priority',
            'information_collection.created_at','information_collection.updated_at')
//            ->with('comments', 'comments.commenter')
            ->join('users','information_collection.assigner_id','users.id')
            ->join('ministries','users.ministry_id','ministries.id')
            ->where('assigner_id', $this->getAuthId())
            ->where('ministries.status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate($paginationNo);
    }

    /**
     * Get Information Detail For Ministry Admin
     *
     * @param int $informationId
     * @return mixed
     */
    public function getInformationDetailForMinistryAdmin(int $informationId)
    {
        $data = InformationCollection::select('information_collection.id as information_id','info_receivers.id as info_receiver_id', 'information_collection.title','information_collection.type'
            ,'information_collection.agency_type','information_collection.template_id','information_collection.description','information_collection.main_doc','information_collection.main_doc_path',
            'information_collection.main_doc_type','information_collection.supporting_doc','information_collection.supporting_doc_path',
            'information_collection.supporting_doc_type','information_collection.document_type','information_collection.assigner_id',
            'information_collection.start_date','information_collection.submission_date','information_collection.status as information_status','information_collection.priority',
            'info_receivers.status as info_receiver_status',
            'information_collection.created_at','information_collection.updated_at')
            ->with('creator')
            ->join('users','information_collection.assigner_id','users.id')
            ->join('ministries','users.ministry_id','ministries.id')
            ->join('info_receivers','information_collection.id','info_receivers.information_id')
            ->where('assigner_id', $this->getAuthId())
            ->where('ministries.status', 1)
            ->where('information_collection.id', $informationId)
            ->first();


        if (!$data){
            return false;
        }

        $data->comments =  InformationComment::with(['commenter' => function($query) {
            $query->with('roles');
        }])
            ->where('information_id', $informationId)->get();

        $data->documents = [];

        if ($data->type == 'invitational') {
            $documents = InformationDocument::select([
                'documents.answer','documents.id as document_id',
                'documents.main_doc as main_document', 'documents.main_doc_path as main_document_path',
                'documents.supporting_doc as supporting_document', 'documents.supporting_doc_path as supporting_document_path',
                'documents.created_at as document_created_at',
            ])
                ->where('documents.info_receiver_id', $data->info_receiver_id)
                ->get();
            $data->documents = $documents;
        }

        if ($data->type == 'information_collection') {
            $documents = TemplateField::select([
                'template_fields.name as field_name', 'template_fields.type as field_type',
                'template_fields.default as field_default', 'template_fields.options',
                'template_fields.id as field_id', 'documents.answer','documents.id as document_id',
                'documents.created_at as document_created_at',
            ])
                ->join('templates', 'template_fields.template_id', 'templates.id')
                ->join('information_collection', 'templates.id', '=', 'information_collection.template_id')
                ->join('info_receivers', 'information_collection.id', '=' , 'info_receivers.information_id')
                ->leftJoin('documents', function ($join) {
                    $join->on('documents.info_receiver_id', '=', 'info_receivers.id')
                        ->whereRaw('documents.field_id = template_fields.id');
                })
                ->where('documents.info_receiver_id', $data->info_receiver_id)
                ->get();
            $data->documents = $documents;
        }

        $data->count_summary = $this->countSummaryForInformation($informationId);

        return $data;
    }

    /**
     * Get Assigned User Information List For Ministry Admin
     * @param int $informationId
     * @return mixed
     */
    public function fetchAssignedUserInformationListForMinistryAdmin(int $informationId)
    {
        $information = InformationCollection::select('information_collection.id as information_id','information_collection.priority as priority ',
            'information_collection.main_doc','information_collection.main_doc_path',
            'information_collection.main_doc_type','information_collection.supporting_doc','information_collection.supporting_doc_path',
            'information_collection.supporting_doc_type','information_collection.start_date as start_date',
            'information_collection.submission_date as submission_date', 'information_collection.type as information_type','information_collection.agency_type')
            ->join('users','information_collection.assigner_id','users.id')
            ->join('ministries', 'users.ministry_id','ministries.id')
            ->where('information_collection.id', $informationId)
            ->where('ministries.status', 1)
            ->first();

        $assignedUserList = InformationReceiver::select('info_receivers.id as info_receiver_id','info_receivers.lg_id as lg_id','local_governments.name as lg_name','local_governments.type as lg_type',
            'info_receivers.ministry_id as ministry_id','ministries.name as ministry_name','info_receivers.office_id as office_id',
            'ministry_offices.name as mo_name','info_receivers.status as status','info_receivers.is_opened as Is_Opened', 'info_receivers.when_opened as when_opened','documents.main_doc_path as receiver_main_doc_path')
            ->leftJoin('local_governments', function ($join) {
                $join->on('local_governments.id', '=', 'info_receivers.lg_id')
                    ->where('local_governments.status' , 1);
            })
            ->leftJoin('ministries', function ($join) {
                $join->on('ministries.id', '=', 'info_receivers.ministry_id')
                    ->where('ministries.status' , 1);
            })
            ->leftJoin('ministry_offices', function ($join) {
                $join->on('ministry_offices.id', '=', 'info_receivers.office_id')
                    ->where('ministry_offices.status' , 1);
            })
            ->leftJoin('documents', function ($join){
                $join->on('documents.info_receiver_id', '=', 'info_receivers.id')
                    ->where('main_doc_path', '!=', '');
            })
//            ->leftJoin('local_governments', 'info_receivers.lg_id', '=', 'local_governments.id')
//            ->leftJoin('ministries', 'info_receivers.ministry_id', '=', 'ministries.id')
//            ->leftJoin('ministry_offices', 'info_receivers.office_id', '=', 'ministry_offices.id')
            ->where('info_receivers.information_id', $informationId)
            ->get();

        return [
            'information' => $information,
            'association' => $assignedUserList
        ];
    }


    /**
     * Get Assigned User Information Detail For Ministry Admin
     * @param int $infoReceiverId
     * @return mixed
     */
    public function fetchAssignedUserInformationDetailForMinistryAdmin(int $infoReceiverId)
    {
        return InformationDocument::where('info_receiver_id', $infoReceiverId)
            ->leftJoin('template_fields','documents.field_id','template_fields.id')
            ->first();
    }

    /**
     * Get Total Information For Ministry Admin
     *
     * @return mixed
     */
    public function totalInformationForMinistryAdmin()
    {
        $authMinistryId = $this->getAuthMinistryId();

        /*$ministryOfficeIds = MinistryOffices::where('ministry_id', $authMinistryId)
            ->where('status', 1)
            ->get()
            ->pluck('id')
            ->toArray();*/

        $totalMinistryUsers = User::where('status', 1)
            ->where('ministry_id', $authMinistryId)
            ->count();

        $totalUsers = ($totalMinistryUsers - 1);

        $totalInformationCompleted = InformationCollection::where('assigner_id', $this->getAuthId())
            ->where('status' , '=' ,getCompletedStatus())
            ->get();

        $totalInformationProcessing = InformationCollection::where('assigner_id', $this->getAuthId())
            ->where('status' , getProcessingStatus())
            ->get();

        $totalInformationCollected = InformationCollection::where('assigner_id', $this->getAuthId())->get();

        return array(
            'total_ministry_user' => $totalUsers,
            'total_information_completed' => $totalInformationCompleted->count(),
            'total_information_processing'=> $totalInformationProcessing->count(),
            'total_information_collection'=> $totalInformationCollected->count(),
        );
    }

    /**
     * Get Information For Ministry Admin/cao/officer
     *
     * @return mixed
     */
    public function getInformationForMinistry()
    {
        $paginationNo = request()->has('pagination_no') ? request()->get('pagination_no') : 12;

        return InformationCollection::select([
            'information_collection.*', 'info_receivers.id as info_receiver_id','information_collection.id as information_id', 'information_collection.status as information_status',
            'info_receivers.status as info_receiver_status',
            DB::raw('(SELECT documents.main_doc_path FROM documents WHERE documents.info_receiver_id = info_receivers.id LIMIT 1) as receiver_main_doc_path'),
            DB::raw('(SELECT documents.supporting_doc_path FROM documents WHERE documents.info_receiver_id = info_receivers.id LIMIT 1) as receiver_supporting_doc_path'),
        ])
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->join('ministries', 'info_receivers.ministry_id', 'ministries.id')
            ->with('comments')
            ->where('info_receivers.ministry_id', $this->getAuthMinistryId())
            ->where('ministries.status', 1)
            ->orderBy('information_collection.created_at','DESC')
            ->paginate($paginationNo);
    }

    /**
     * Get Information Detail For Ministry Admin/Officer/CAo
     *
     * @param int $informationId
     * @return mixed
     */
    public function getInformationDetailForMinistry(int $informationId)
    {
        $information = InformationCollection::select(
            'information_collection.*', 'info_receivers.status as info_receiver_status', 'info_receivers.id as info_receiver_id'
        )
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->where('info_receivers.information_id',$informationId)
            ->where('info_receivers.ministry_id', $this->getAuthMinistryId())
            ->first();

        if (!$information){
            return false;
        }

        // If not opened set time and opened status

        $this->setOpenedTimeNStatus($information, $informationId);

        $data = InformationCollection::select('info_receivers.id as info_receiver_id','information_collection.id as information_id', 'information_collection.title','information_collection.type'
            ,'information_collection.agency_type','information_collection.template_id','information_collection.description','information_collection.main_doc','information_collection.main_doc_path',
            'information_collection.main_doc_type','information_collection.supporting_doc','information_collection.supporting_doc_path',
            'information_collection.supporting_doc_type','information_collection.document_type','information_collection.assigner_id',
            'information_collection.start_date','information_collection.submission_date','information_collection.status as information_status','information_collection.priority',
            'information_collection.created_at','information_collection.updated_at','info_receivers.ministry_id','info_receivers.lg_id',
            'info_receivers.office_id','info_receivers.is_opened','info_receivers.when_opened', 'info_receivers.status as info_receiver_status',
            DB::raw('(SELECT documents.main_doc_path FROM documents WHERE documents.info_receiver_id = info_receivers.id LIMIT 1) as receiver_main_doc_path'))
            ->with('creator')
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->where('info_receivers.ministry_id', $this->getAuthMinistryId())
            ->join('ministries', 'info_receivers.ministry_id', 'ministries.id')
            ->where('ministries.status', 1)
            ->where('information_collection.id', $informationId)
            ->first();
        $data->comments =  InformationComment::with('commenter')->where('information_id', $informationId)->get();
        $data->count_summary = $this->countSummaryForInformation($informationId);

        return $data;
    }

    /**
     * Get Information Detail For Ministry Admin/Officer/CAO
     *
     * @param int $infoReceiverId
     * @return mixed
     */
    public function getInformationCollectionDetailForMinistry(int $infoReceiverId)
    {
        $data = InformationCollection::select('information_collection.type','information_collection.status as information_status',
            'info_receivers.status as info_receiver_status')
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->where('info_receivers.id', $infoReceiverId)
            ->first();

        if (!$data){
            return false;
        }
        $documents = [];
        if ($data->type == 'invitational') {
            $documents = InformationDocument::select([
                'documents.id as document_id','documents.info_receiver_id as info_receiver_id',
                'documents.main_doc as main_document', 'documents.main_doc_path as main_document_path',
                'documents.supporting_doc as supporting_document', 'documents.supporting_doc_path as supporting_document_path',
                'documents.created_at as document_created_at'
            ])
                ->where('documents.info_receiver_id', $infoReceiverId)
                ->get();
        }

        if ($data->type == 'information_collection') {
            $documents = TemplateField::select([
                'template_fields.id as field_id', 'template_fields.name as field_name',
                'template_fields.type as field_type',
                'template_fields.default as field_default', 'template_fields.options',
                'info_receivers.id as info_receiver_id',
                'documents.answer','documents.id as document_id',
                'documents.created_at as document_created_at',
            ])
                ->join('templates', 'template_fields.template_id', 'templates.id')
                ->join('information_collection', 'templates.id', '=', 'information_collection.template_id')
                ->join('info_receivers', 'information_collection.id', '=' , 'info_receivers.information_id')
                ->leftJoin('documents', function ($join) {
                    $join->on('documents.info_receiver_id', '=', 'info_receivers.id')
                        ->whereRaw('documents.field_id = template_fields.id');
                })
                ->where('info_receivers.id', $infoReceiverId)
                ->get();
        }
        if (!$documents)
        {
            return false;
        }

        $data->documents = $documents;

        return $data;
    }


    /**
     * Get Information For LG
     *
     * @return mixed
     */
    public function getInformationForLg()
    {
        $paginationNo = request()->has('pagination_no') ? request()->get('pagination_no') : 12;

        return InformationCollection::select([
            'information_collection.*', 'info_receivers.id as info_receiver_id', 'information_collection.id as information_id',
            'information_collection.status as information_status','info_receivers.status as info_receiver_status',
            DB::raw('(SELECT documents.main_doc_path FROM documents WHERE documents.info_receiver_id = info_receivers.id LIMIT 1) as receiver_main_doc_path'),
            DB::raw('(SELECT documents.supporting_doc_path FROM documents WHERE documents.info_receiver_id = info_receivers.id LIMIT 1) as receiver_supporting_doc_path'),
        ])
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->join('local_governments', 'info_receivers.lg_id', 'local_governments.id')
            ->with('comments')
            ->where('info_receivers.lg_id', $this->getAuthLgId())
            ->where('local_governments.status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate($paginationNo);
    }

    /**
     * Get Information Detail For Lg
     *
     * @param int $informationId
     * @return mixed
     */
    public function getInformationDetailForLg(int $informationId)
    {
        $information = InformationCollection::select(
            'information_collection.*', 'info_receivers.status as info_receiver_status', 'info_receivers.id as info_receiver_id'
        )
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->where('info_receivers.information_id',$informationId)
            ->where('info_receivers.lg_id', $this->getAuthLgId())
            ->first();

        if (!$information){
            return false;
        }

        // If not opened set time and opened status

        $this->setOpenedTimeNStatus($information, $informationId);


        $data = InformationCollection::select('info_receivers.id as info_receiver_id','information_collection.id as information_id', 'information_collection.title','information_collection.type'
            ,'information_collection.agency_type','information_collection.template_id','information_collection.description','information_collection.main_doc','information_collection.main_doc_path',
            'information_collection.main_doc_type','information_collection.supporting_doc','information_collection.supporting_doc_path',
            'information_collection.supporting_doc_type','information_collection.document_type','information_collection.assigner_id',
            'information_collection.start_date','information_collection.submission_date','information_collection.status as information_status','information_collection.priority',
            'information_collection.created_at','information_collection.updated_at','info_receivers.ministry_id','info_receivers.lg_id',
            'info_receivers.office_id','info_receivers.is_opened','info_receivers.when_opened','info_receivers.status as info_receiver_status',
            DB::raw('(SELECT documents.main_doc_path FROM documents WHERE documents.info_receiver_id = info_receivers.id LIMIT 1) as receiver_main_doc_path'))
            ->with('creator')
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->join('local_governments', 'info_receivers.lg_id', 'local_governments.id')
            ->where('info_receivers.lg_id', $this->getAuthLgId())
            ->where('local_governments.status', 1)
            ->where('information_collection.id', $informationId)
            ->first();

        $data->comments =  InformationComment::with('commenter')->where('information_id', $informationId)->get();
        $data->count_summary = $this->countSummaryForInformation($informationId);

        return $data;
    }

    /**
     * Get Information Detail For Lg
     *
     * @param int $infoReceiverId
     * @return mixed
     */
    public function getInformationCollectionDetailForLg(int $infoReceiverId)
    {
        $data = InformationCollection::select('information_collection.type','information_collection.status as information_status',
            'info_receivers.status as info_receiver_status')
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->join('local_governments', 'info_receivers.lg_id', 'local_governments.id')
            ->where('info_receivers.id', $infoReceiverId)
            ->where('info_receivers.lg_id', $this->getAuthLgId())
            ->where('local_governments.status', 1)
            ->first();


        if (!$data){
            return false;
        }
        $documents = [];
        if ($data->type == 'invitational') {
            $documents = InformationDocument::select([
                'documents.id as document_id','documents.info_receiver_id as info_receiver_id',
                'documents.main_doc as main_document', 'documents.main_doc_path as main_document_path',
                'documents.supporting_doc as supporting_document', 'documents.supporting_doc_path as supporting_document_path',
                'documents.created_at as document_created_at'
            ])
                ->where('documents.info_receiver_id', $infoReceiverId)
                ->get();
        }

        if ($data->type == 'information_collection') {
            $documents = TemplateField::select([
                'template_fields.id as field_id', 'template_fields.name as field_name',
                'template_fields.type as field_type',
                'template_fields.default as field_default', 'template_fields.options',
                'info_receivers.id as info_receiver_id',
                'documents.answer','documents.id as document_id',
                'documents.created_at as document_created_at',
            ])
                ->join('templates', 'template_fields.template_id', 'templates.id')
                ->join('information_collection', 'templates.id', '=', 'information_collection.template_id')
                ->join('info_receivers', 'information_collection.id', '=' , 'info_receivers.information_id')
                ->leftJoin('documents', function ($join) {
                    $join->on('documents.info_receiver_id', '=', 'info_receivers.id')
                        ->whereRaw('documents.field_id = template_fields.id');
                })
                ->where('info_receivers.id', $infoReceiverId)
                ->get();
        }
        if (!$documents)
        {
            return false;
        }

        $data->document = $documents;

        return $data;
    }

    /**
     * Get Total Information For Lg Admin
     *
     * @return mixed
     */
    public function totalInformationForLgAdmin()
    {
        $authLgId = $this->getAuthLgId();

        $totalUsers = User::where('status', 1)
            ->where('lg_id', $authLgId)->count();

        $totalInformationCompleted = InformationReceiver::where('lg_id', $authLgId)
            ->where('status' , '=' ,getCompletedStatus())
            ->get();

        $totalInformationProcessing = InformationReceiver::where('lg_id', $authLgId)
            ->where('status' , '=' ,getProcessingStatus())
            ->get();

        $totalInformationCollected = InformationReceiver::where('lg_id', $authLgId)
            ->get();

        return [
            'total_lg_user' => $totalUsers,
            'total_information_completed' => $totalInformationCompleted->count(),
            'total_information_processing'=> $totalInformationProcessing->count(),
            'total_information_collection'=> $totalInformationCollected->count(),
        ];
    }

    /**
     * Get Information For Ministry Office
     *
     * @return mixed
     */
    public function getInformationForMinistryOffice()
    {
        $paginationNo = request()->has('pagination_no') ? request()->get('pagination_no') : 12;

        return InformationCollection::select([
            'information_collection.*', 'info_receivers.id as info_receiver_id', 'information_collection.id as information_id',
            'information_collection.status as information_status','info_receivers.status as info_receiver_status',
            DB::raw('(SELECT documents.main_doc_path FROM documents WHERE documents.info_receiver_id = info_receivers.id LIMIT 1) as receiver_main_doc_path'),
            DB::raw('(SELECT documents.supporting_doc_path FROM documents WHERE documents.info_receiver_id = info_receivers.id LIMIT 1) as receiver_supporting_doc_path'),
        ])
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->join('ministry_offices', 'info_receivers.office_id', 'ministry_offices.id')
            ->with('comments')
            ->where('info_receivers.office_id', $this->getAuthMinistryOfficeId())
            ->where('ministry_offices.status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate($paginationNo);
    }

    /**
     * Get Information Detail For Ministry Office
     *
     * @param int $informationId
     * @return mixed
     */
    public function getInformationDetailForMinistryOffice(int $informationId)
    {
        $information = InformationCollection::select(
            'information_collection.*', 'info_receivers.status as info_receiver_status', 'info_receivers.id as info_receiver_id'
        )
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->where('info_receivers.information_id',$informationId)
            ->where('info_receivers.office_id', $this->getAuthMinistryOfficeId())
            ->first();

        if (!$information){
            return false;
        }

        // If not opened set time and opened status

        $this->setOpenedTimeNStatus($information, $informationId);

        $data = InformationCollection::select('info_receivers.id as info_receiver_id','information_collection.id as information_id', 'information_collection.title','information_collection.type'
            ,'information_collection.agency_type','information_collection.template_id','information_collection.description','information_collection.main_doc','information_collection.main_doc_path',
            'information_collection.main_doc_type','information_collection.supporting_doc','information_collection.supporting_doc_path',
            'information_collection.supporting_doc_type','information_collection.document_type','information_collection.assigner_id',
            'information_collection.start_date','information_collection.submission_date','information_collection.status as information_status','information_collection.priority',
            'information_collection.created_at','information_collection.updated_at','info_receivers.ministry_id','info_receivers.lg_id',
            'info_receivers.office_id','info_receivers.is_opened','info_receivers.when_opened','info_receivers.status as info_receiver_status',
            DB::raw('(SELECT documents.main_doc_path FROM documents WHERE documents.info_receiver_id = info_receivers.id LIMIT 1) as receiver_main_doc_path'))
            ->with('creator')
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->join('ministry_offices', 'info_receivers.office_id', 'ministry_offices.id')
            ->where('info_receivers.office_id', $this->getAuthMinistryOfficeId())
            ->where('ministry_offices.status', 1)
            ->where('information_collection.id', $informationId)
            ->first();

        $data->comments =  InformationComment::with('commenter')->where('information_id', $informationId)->get();
        $data->count_summary = $this->countSummaryForInformation($informationId);

        return $data;
    }

    /**
     * Get Information Detail For Ministry Office
     *
     * @param int $infoReceiverId
     * @return mixed
     */
    public function getInformationCollectionDetailForMinistryOffice(int $infoReceiverId)
    {
        $data = InformationCollection::select('information_collection.type','information_collection.status as information_status',
            'info_receivers.status as info_receiver_status')
            ->join('info_receivers', 'information_collection.id', 'info_receivers.information_id')
            ->join('ministry_offices', 'info_receivers.office_id', 'ministry_offices.id')
            ->where('info_receivers.id', $infoReceiverId)
            ->where('info_receivers.office_id', $this->getAuthMinistryOfficeId())
            ->where('ministry_offices.status', 1)
            ->first();

        if (!$data){
            return false;
        }
        $documents = [];

        if ($data->type == 'invitational') {
            $documents = InformationDocument::select([
                'documents.id as document_id','documents.info_receiver_id as info_receiver_id',
                'documents.main_doc as main_document', 'documents.main_doc_path as main_document_path',
                'documents.supporting_doc as supporting_document', 'documents.supporting_doc_path as supporting_document_path',
                'documents.created_at as document_created_at'
            ])
                ->where('documents.info_receiver_id', $infoReceiverId)
                ->get();
        }

        if ($data->type == 'information_collection') {
            $documents = TemplateField::select([
                'template_fields.id as field_id', 'template_fields.name as field_name',
                'template_fields.type as field_type',
                'template_fields.default as field_default', 'template_fields.options',
                'info_receivers.id as info_receiver_id',
                'documents.answer','documents.id as document_id',
                'documents.created_at as document_created_at',
            ])
                ->join('templates', 'template_fields.template_id', 'templates.id')
                ->join('information_collection', 'templates.id', '=', 'information_collection.template_id')
                ->join('info_receivers', 'information_collection.id', '=' , 'info_receivers.information_id')
                ->leftJoin('documents', function ($join) {
                    $join->on('documents.info_receiver_id', '=', 'info_receivers.id')
                        ->whereRaw('documents.field_id = template_fields.id');
                })
                ->where('info_receivers.id', $infoReceiverId)
                ->get();
        }

        if (!$documents)
        {
            return false;
        }


        $data->documents = $documents;

        return $data;
    }

    /**
     * Get Total Information For Ministry Office Admin
     *
     * @return mixed
     */
    public function totalInformationForMinistryOfficeAdmin()
    {
        $authMoId = $this->getAuthMinistryOfficeId();

        $totalUsers = User::where('status', 1)
            ->where('office_id', $authMoId)->count();

        $totalInformationCompleted = InformationReceiver::where('office_id', $authMoId)
            ->where('status' , '=' ,getCompletedStatus())
            ->get();

        $totalInformationProcessing = InformationReceiver::where('office_id', $authMoId)
            ->where('status' , '=' ,getProcessingStatus())
            ->get();

        $totalInformationCollected = InformationReceiver::where('office_id', $authMoId)
            ->get();

        return [
            'total_mo_user' => $totalUsers,
            'total_information_completed' => $totalInformationCompleted->count(),
            'total_information_processing'=> $totalInformationProcessing->count(),
            'total_information_collection'=> $totalInformationCollected->count(),
        ];
    }

    /**
     * Start Processing Information
     *
     * @param int $informationId
     * @return void
     */
    public function startProcessingByLgAdmin(int $informationId)
    {
        InformationCollection::where('id', $informationId)->update([
            'status' => getProcessingStatus(),
        ]);
    }


    /**
     * Set Information Completed
     *
     * @param int $infoReceiverId
     * @return void
     */
    public function setInformationCompleted(int $infoReceiverId)
    {
        $infoReceiver = InformationReceiver::find($infoReceiverId);
        $infoReceiver->status = getCompletedStatus();
        $infoReceiver->save();

        $this->setInformationCompletedIfAllInfoReceiverIsCompleted($infoReceiver->information_id);

        /*


                $infoReceiver = InformationReceiver::where('id', $infoReceiverId)->first();

                // For invitational
                $information = InformationCollection::where('id', $infoReceiver->information_id)->first();
                if ($information->type == 'circular' && $infoReceiver->is_opened == 1)
                {
                    InformationCollection::where('id', $infoReceiver->information_id)->update(['status' => getCompletedStatus()]);
                    return true;
                }
                $documentCount = InformationDocument::where('info_receiver_id', $infoReceiverId)->count();

                //For invitational
                if ($information->type == 'invitational')
                {
                    // info receivers status to complete
                    if ($documentCount > 0){
                        InformationReceiver::where('id', $infoReceiverId)->update(['status' => getCompletedStatus()]);

                        // information collection status to complete
                        $infoReceiverLatest = InformationReceiver::where('id', $infoReceiverId)->first();
                        $informationCount = InformationReceiver::where('information_id', $infoReceiverLatest->information_id)->count();
                        $informationStatusCount = InformationReceiver::where('information_id', $infoReceiverLatest->information_id)
                            ->where('status', getCompletedStatus())->count();
                        if ($informationCount == $informationStatusCount){
                            InformationCollection::where('id', $infoReceiverLatest->information_id)->update(['status' => getCompletedStatus()]);
                        }

                        return true;
                    }
                }

                if ($information->type == 'information_collection')
                {
                    $fieldCount = InformationCollection::join('templates','information_collection.template_id','templates.id')
                        ->join('template_fields','templates.id','template_fields.template_id')
                        ->where('information_collection.id', $infoReceiver->information_id)
                        ->count();

                    // info receivers status to complete
                    if ($fieldCount == $documentCount){
                        InformationReceiver::where('id', $infoReceiverId)->update(['status' => getCompletedStatus()]);

                        // information collection status to complete
                        $infoReceiverLatest = InformationReceiver::where('id', $infoReceiverId)->first();
                        $informationCount = InformationReceiver::where('information_id', $infoReceiverLatest->information_id)->count();
                        $informationStatusCount = InformationReceiver::where('information_id', $infoReceiverLatest->information_id)
                            ->where('status', getCompletedStatus())->count();
                        if ($informationCount == $informationStatusCount){
                            InformationCollection::where('id', $infoReceiverLatest->information_id)->update(['status' => getCompletedStatus()]);
                        }

                        return true;
                    }
                }

                return false;*/

    }

    /**
     * Set Information Approved
     *
     * @param int $infoReceiverId
     * @return mixed
     */
    public function setInformationApproved(int $infoReceiverId)
    {
        return InformationReceiver::where('id', $infoReceiverId)->update(['status' => getApprovalStatus()]);
    }

    /**
     * Find Information Collection
     *
     * @param int $informationId
     * @return mixed
     */
    public function getInformationById(int $informationId)
    {
        return InformationCollection::find($informationId);
    }

    private function getMinistryOfficersByMinistry($agencyId)
    {
        return User::select('users.id', 'users.id as user_id')->join('roles', 'users.role_id', 'roles.id')
            ->where('roles.slug', getMinistryOfficerRole())
            ->where('users.ministry_id', $agencyId)
            ->get();
    }

    private function getLgOfficersByLg($agencyId)
    {
        return User::select('users.id', 'users.id as user_id')->join('roles', 'users.role_id', 'roles.id')
            ->where('roles.slug', getLgOfficerRole())
            ->where('users.lg_id', $agencyId)
            ->get();
    }


    /**
     * Get Information Collection Report For Ministry
     *
     * @return mixed
     */
    public function getInformationCollectionReportForMinistry()
    {
        $infoReport = InformationCollection::select('local_governments.name as lg_name', 'ministries.name as ministry_name',
            'ministry_offices.name as mo_name', 'template_fields.name as question', 'documents.answer as answer'
//            'template_fields.id as field_id', 'templates.id as template_id'
        )
            ->join('templates', 'information_collection.template_id', 'templates.id')
            ->join('template_fields', 'templates.id', 'template_fields.template_id')
            ->join('info_receivers','information_collection.id', 'info_receivers.information_id')
            ->leftJoin('local_governments', 'info_receivers.lg_id','local_governments.id')
            ->leftJoin('ministries', 'info_receivers.ministry_id','ministries.id')
            ->leftJoin('ministry_offices', 'info_receivers.office_id','ministry_offices.id')
            ->leftJoin('documents', function ($join) {
                $join->on('documents.info_receiver_id', '=', 'info_receivers.id')
                    ->whereRaw('documents.field_id = template_fields.id');
            })
            ->where('assigner_id', $this->getAuthId())
            ->get();

        return $infoReport;

    }


    /**
     * Find Information Collection
     *
     * @param int $informationId
     * @return mixed
     */
    public function downloadInformationById(int $informationId)
    {
        return InformationCollection::find($informationId);
    }

    /**
     * Get Information Collection
     *
     * @param string $type
     * @param string $title
     * @param string $status
     * @param string $paginationNo
     * @return mixed
     */
    public function getInformationCollection(string $type, string $title, string $status, string $paginationNo)
    {
        return InformationCollection::where(function ($query) use ($type, $title, $status){
            if (!isStringEmpty($type)){
                $query->where('information_collection.type', 'LIKE', '%'.$type.'%');
            }
            if (!isStringEmpty($title)){
                $query->where('information_collection.title', 'LIKE', '%'.$title.'%');
            }
            if (!isStringEmpty($status)){
                $query->where('information_collection.status', 'LIKE', '%'.$status.'%');
            }
        })
            ->paginate($this->getPaginationNo($paginationNo))
            ->get();
    }

    /**
     * getMinistryOfficeInformation
     *
     * @param int $ministryId
     * @return mixed
     */
    public function getMinistryOfficeInformation(int $ministryId)
    {
        return MinistryOffices::select('ministry_offices.id as ministry_office_id','ministry_offices.name as ministry_office_name')
            ->where('ministry_id', $ministryId)->where('status', 1)->get();
    }



    private function countSummaryForInformation(int $informationId)
    {
        $infoReceivers = InformationReceiver::join('information_collection','info_receivers.information_id','information_collection.id')
            ->where('info_receivers.information_id', $informationId)
            ->get();

        $array = [
            'lg_ids' => [],
            'ministry_ids' => [],
            'office_ids' => [],
        ];
        foreach ($infoReceivers as $infoReceiver) {
            if (!is_null($infoReceiver->ministry_id)) {
                $array['ministry_ids'][] = $infoReceiver->ministry_id;
            }
            if (!is_null($infoReceiver->lg_id)) {
                $array['lg_ids'][] = $infoReceiver->lg_id;
            }
            if (!is_null($infoReceiver->office_id)) {
                $array['office_ids'][] = $infoReceiver->office_id;
            }
        }

        $district_count = 0;

        if (count($array['lg_ids']) > 0) {
            foreach ($array['lg_ids'] as $lg_id){
                $district[] = LocalGovernment::where('id', $lg_id)->pluck('district_id');
            }
            $district_count = count(array_unique($district));
        }

        return [
            'ministry_count' =>  isset($array['ministry_ids']) ? count($array['ministry_ids']) : 0,
            'office_count' => isset($array['office_ids']) ? count($array['office_ids']) : 0,
            'lg_count' => isset($array['lg_ids']) ? count($array['lg_ids']) : 0,
            'district_count' => $district_count
        ];
    }

    /**
     * Set Information Completed if all info receivers has completed
     *
     * @param $informationId
     * @return void
     */
    private function setInformationCompletedIfAllInfoReceiverIsCompleted($informationId)
    {
        $distributedInformationCount = InformationReceiver::where('information_id', $informationId)->count();
        $completedInformationCount = InformationReceiver::where('information_id', $informationId)->where('status', getCompletedStatus())->count();
        if ($distributedInformationCount == $completedInformationCount) {
            InformationCollection::where('id', $informationId)->update(['status' => getCompletedStatus()]);
        }
    }

    /**
     * set opened time and status for info receiver collection
     *
     * @param $information
     * @param $informationId
     * @return void
     */
    public function setOpenedTimeNStatus($information, $informationId)
    {
        if ( !($information->is_opened) ) {
            $informationViewedStatus = [
                'is_opened' => 1,
                'when_opened' => date('Y-m-d H:i:s'),
            ];
            if ($information->info_receiver_status == getPendingStatus()) {
                $informationViewedStatus['status'] = getProcessingStatus();
                if ($information->type == getCircularInfoType())
                {
                    $informationViewedStatus['status'] = getCompletedStatus();
                }
            }
            InformationReceiver::where('id', $information->info_receiver_id)->update($informationViewedStatus);
            if ($information->type == getCircularInfoType()) {
                $this->setInformationCompletedIfAllInfoReceiverIsCompleted($informationId);
            }
        } else {
            if ($information->type == getCircularInfoType() && $information->info_receiver_status != getCompletedStatus()) {
                InformationReceiver::where('id', $information->info_receiver_id)->update([
                    'status' => getCompletedStatus()
                ]);
                $this->setInformationCompletedIfAllInfoReceiverIsCompleted($informationId);
            }
        }
    }

}
