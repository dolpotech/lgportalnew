<?php

namespace App\Http\Controllers;

use App\HelperClasses\Traits\ApiResponse;
use App\HelperClasses\Traits\ArticlesSearch;
use App\HelperClasses\Traits\KeywordSearch;
use App\HelperClasses\Traits\NepalitoEnglish;
use App\HelperClasses\Traits\Searchtext;
use App\Models\Article;
use App\Models\Contact;
use App\Models\District;
use App\Models\ElectedOfficials;
use App\Models\ElectedProfile;
use App\Models\EmergencyNumber;
use App\Models\Gallery;
use App\Models\ImportantPlaces;
use App\Models\Introduction;
use App\Models\LocalGovernment;
use App\Models\Document;
use App\Models\Ministry;
use App\Models\ResourceMap;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Staff;
use App\Models\Ward;
use App\Models\WardOfficials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DataController extends Controller
{
    use ApiResponse;
    use KeywordSearch;
    use Searchtext;
    use NepalitoEnglish;
    use ArticlesSearch;
    public function getdistrictbypradesh()
    {
        $district_list = District::where('province_id', 5)->get();
        return $this->sendApiSuccessResponse($district_list, "district by province", 1);
    }

    public function getAllLG(Request $request)
    {
        $district_id=$request->has('district_id')?$request->get('district_id'):null;
        $lg_type=$request->has('lg_type')?$request->get('lg_type'):null;
        $lglist = DB::table('local_governments')
            ->join('districts', 'districts.id', '=', 'local_governments.district_id')
            ->where(function($query) use($district_id, $lg_type){
                if($district_id!=null && $lg_type==null){
                    $query->where('local_governments.district_id', '=', $district_id);
                }
                if($district_id!=null && $lg_type!=null){
                    $query->where('local_governments.district_id', '=', $district_id)
                         ->where('local_governments.type', '=', $lg_type);
                }
                if($district_id==null && $lg_type!=null){
                    $query->where('local_governments.type', '=', $lg_type);
                }


                })
            ->where('local_governments.province_id', '=', 5)
            ->get(["local_governments.*","districts.name_en as district","districts.name as district_nep"]);
        return $this->sendApiSuccessResponse($lglist, "lg list", 1);
    }
//    public function designationlist()
//    {
//        $designationlist = DB::Table('staffs')->select('designation as name')->distinct()->get();
//            return $this->sendApiSuccessResponse($designationlist, "designation list staff", 1);
//    }
    public function designationlist(Request $request)
    {
        $id = $request->get('lg_id');
        $lg=LocalGovernment::find($id);
        if($lg!=null) {
            $designationlist = DB::Table('staffs')->select('designation as name')->where('lg_id', $id)->distinct()->get();
            return $this->sendApiSuccessResponse($designationlist, "designation list staff", 1);
        }
        else{
            $designationlist = DB::Table('staffs')->select('designation as name')->distinct()->get();
            return $this->sendApiSuccessResponse($designationlist, "designation list staff by lg", 1);

        }
    }
//    public function documenttypelist()
//    {
//        $documenttypelist = DB::Table('lg_documents')->select('Document_Type as name')->distinct()->get();
//        return $this->sendApiSuccessResponse($documenttypelist, "document type list", 1);
//
//    }
    public function documenttypelist(Request  $request)
    {
        $id = $request->get('lg_id');
        $lg=LocalGovernment::find($id);
        if($lg!=null) {
            $documenttypelist = DB::Table('lg_documents')->select('Document_Type as name')->where('lg_id', $id)->distinct()->get();
            return $this->sendApiSuccessResponse($documenttypelist, "document type list", 1);
        }
        else{
            $documenttypelist = DB::Table('lg_documents')->select('Document_Type as name')->distinct()->get();
            return $this->sendApiSuccessResponse($documenttypelist, "document type list by lg", 1);

        }
    }
//    public function servicetypelist()
//    {
//        $servicetypelist = DB::Table('services')->select('service_type as name')->distinct()->get();
//        return $this->sendApiSuccessResponse($servicetypelist, "service type list", 1);
//
//    }
    public function servicetypelist(Request  $request)
    {
        $id = $request->get('lg_id');
        $lg = LocalGovernment::find($id);
        if ($lg != null) {
            $servicetypelist = DB::Table('services')->select('service_type as name')->where('lg_id', $id)->distinct()->get();
            return $this->sendApiSuccessResponse($servicetypelist, "service type list", 1);
        }
        else{
        $servicetypelist = DB::Table('services')->select('service_type as name')->distinct()->get();
        return $this->sendApiSuccessResponse($servicetypelist, "service type list", 1);

        }
    }
    public function article_tag_list(Request  $request){
        $id = $request->get('lg_id');
        $lg = LocalGovernment::find($id);
        if ($lg != null) {
            $articles=DB::table('articles')->select('tags as name')->where('lg_id', $id)->distinct()->get();
            return $this->sendApiSuccessResponse($articles, "article  list", 1);
        }
        else{
            $articles=DB::table('articles')->select('tags as name')->distinct()->get();
            return $this->sendApiSuccessResponse($articles, "article  list", 1);

        }

    }
//    public function contacttitlelist(Request $request)
//    {
//
//            $contacttitlelist = DB::Table('contacts')->select('title')->distinct()->get();
//            return $this->sendApiSuccessResponse($contacttitlelist, "contact title list", 1);
//
//    }

    public function elected_official_designation(Request $request){
        $id = $request->get('lg_id');
        $lg = LocalGovernment::find($id);
        if ($lg != null) {
            $designationlist = DB::table('elected_officials')->select('designation as name')->where('lg_id', $id)->distinct()->get();
            return $this->sendApiSuccessResponse($designationlist, "elected official designation list", 1);
        }
        else{
            $designationlist = DB::table('elected_officials')->select('designation as name')->distinct()->get();
            return $this->sendApiSuccessResponse($designationlist, " elected official designation list", 1);

        }

    }
    public function contacttitlelist(Request $request)
    {
        $id = $request->get('lg_id');
        $lg = LocalGovernment::find($id);
        if ($lg != null) {
            $contacttitlelist = DB::Table('contacts')->select('title')->where('lg_id', $id)->distinct()->get();
            return $this->sendApiSuccessResponse($contacttitlelist, "contact title list", 1);
        }
        else{
            $contacttitlelist = DB::Table('contacts')->select('title')->distinct()->get();
            return $this->sendApiSuccessResponse($contacttitlelist, "contact title list", 1);

        }
    }

    public  function number_of_lg()
    {
        $local_government = LocalGovernment::where('province_id', '5')->count();
        return $this->sendApiSuccessResponse($local_government, "number of lg", 1);
    }


    public function  number_of_wards($id)
    {
        $number_of_wards = Ward::where('lg_id', $id)->count();
        return $this->sendApiSuccessResponse($number_of_wards, "number of wards", 1);
    }
    public  function total_number_of_elected_officials($id)
    {
        $number_of_elected_representative = ElectedOfficials::where('lg_id', $id)->count();
        return $this->sendApiSuccessResponse($number_of_elected_representative, "number of elected representative", 1);
    }
    public function lg_details($id)
    {
        $lg=LocalGovernment::find($id);
        if($lg!=null) {
//            $lg_website=$lg;
            $local_gov=DB::table('local_governments')
                        ->join('districts', 'local_governments.district_id', '=', 'districts.id' )
                        ->where('local_governments.id', $id)
                        ->get(["local_governments.*","districts.name_en as district","districts.name as district_nep"]);
            $contactdata =Contact::select('email', 'telephone')->where('lg_id', $id)->get()->first();
           if($contactdata!=null) {
               $contactemails = explode(',', $contactdata->email);
               $lg_email = $contactemails[0];
               $lg_phone=$contactdata->telephone;
               $lg_contact[]=['email'=>$lg_email,'phone'=> $lg_phone];
           }else{
               $lg_contact="No data";
           }
           $elected_officials = ElectedOfficials::where('lg_id', $id)->get()->toArray();
           $documents=Document::where('lg_id', $id)->get()->toArray();
            $elected_profiles= ElectedProfile::where('lg_id', $id)->get()->toArray();
            $ward_info = Ward::where('lg_id', $id)->get()->toArray();
            $contacts = Contact::where('lg_id', $id)->get()->toArray();
            $articles = Article::where('lg_id', $id)->limit(5)->get()->toArray();
            $introduction = Introduction::where('lg_id', $id)->get()->toArray();
            $staffs= Staff::where('lg_id', $id)->get()->toArray();
            $ward_officials = WardOfficials::where('lg_id', $id)->get()->toArray();
            $emergency_numbers = EmergencyNumber::where('lg_id', $id)->get()->toArray();
            $important_places=ImportantPlaces::where('lg_id', $id)->get()->toArray();
            $mainposition=['Mayor','नगरप्रमुख','नगर प्रमुख','प्रमुख','अध्यक्ष','गा.पा.अध्यक्ष','गाउँपालिका अध्यक्ष'];
            $subposition=['उप प्रमुख','नगर उप प्रमुख','नगर उप-प्रमुख','उप– प्रमुख','नगर उप– प्रमुख','नगर उप-प्रमुख','नगर उप–प्रमुख','उपाध्यक्ष'];
            $rep1= ElectedOfficials::
            select('title', 'photo', 'phone', 'designation as position')
                ->where('lg_id', $id)
                ->whereIn('designation', $mainposition)
                ->limit(1)
                ->first();

            $rep2=ElectedOfficials::
            select('title', 'photo', 'phone', 'designation as position')
                ->where('lg_id', $id)
                ->whereIn('designation', $subposition)
                ->limit(1)
                ->first();
            $pravakta=[$rep1, $rep2];
            if($rep1==null && $rep2==null){
                $pravakta="No data";
            }
            if($rep1!=null && $rep2==null){
                $pravakta=ElectedOfficials::
                select('title', 'photo', 'phone', 'designation as position')
                    ->where('lg_id', $id)
                    ->whereIn('designation', $mainposition)
                    ->limit(1)
                    ->get();
            }
            if($rep1==null && $rep2!=null){
                $pravakta=ElectedOfficials::
                select('title', 'photo', 'phone', 'designation as position')
                    ->where('lg_id', $id)
                    ->whereIn('designation', $subposition)
                    ->limit(1)
                    ->get();
            }
            if($id==50903){
                $pravakta=ElectedOfficials::
                select('title', 'photo', 'phone', 'designation as position')
                    ->where('lg_id', $id)
                    ->limit(2)
                    ->get();

            }
//            $pravakta=ElectedOfficials::where('lg_id', $id)->where('designation', 'प्रवक्ता')->get()->toArray();
//            if($pravakta===[]){
//                $pravakta=ElectedOfficials::where('lg_id', $id)->limit(2)->get()->toArray();
//            }
            $services=Service::where('lg_id', $id)->get()->toArray();
            $resource_maps=ResourceMap::where('lg_id', $id)->get()->toArray();
            $data = compact('local_gov','lg_contact','pravakta','elected_officials','documents','ward_info', 'contacts', 'articles', 'introduction', 'elected_profiles', 'staffs', 'ward_officials', 'emergency_numbers', 'important_places', 'documents','services','resource_maps');
            $message = "lg details";
            $status = 1;
            return $this->sendApiSuccessResponse($data, $message, $status);
        }
        else{
            return ["Result"=>"lg does not exist"];
        }
    }

    public function  number_of_staff($id)
    {
        $lg=LocalGovernment::find($id);
        if($lg!=null) {
            $staff_count = Staff::where('lg_id', $id)->count();
            return $this->sendApiSuccessResponse($staff_count, "Number of staff", 1);
        }
        else{
            return ["Result"=>"lg does not exist"];
        }
    }




    public function staff_data_lg($id)
    {
        $staff = Staff::where('lg_id', $id)->get();
        $data = $staff;
        $message = "List of staff data";
        $status = "1";
        return $this->sendApiSuccessResponse($data, $message, $status);
    }

    public function document_data($id)
    {
        $document = Document::where('lg_id', $id)->get();
        $data = $document;
        $message = "List of document";
        $status = 1;
        return $this->sendApiSuccessResponse($data, $message, $status);
    }

    public  function elected_official($id)
    {
        $elected_officials = ElectedOfficials::where('lg_id', $id)->get();
        $data = $elected_officials;
        $message = "list of elected_official";
        $status = 1;
        return $this->sendApiSuccessResponse($data, $message, $status);
    }
    public function articles($id)
    {
        $lg=LocalGovernment::find($id);
        if($lg!=null) {
            $articles = Article::where('lg_id', $id)->get();
            $data = $articles;
            $message = "List of articles";
            $status = 1;
            return $this->sendApiSuccessResponse($data, $message, $status);
        }
        else{
            return ["Result"=>"lg does not exist"];
        }

    }
    public function search_keyword(Request $request)
    {
        $paginationNo =10;
        $keyword = $request->get('keyword');
        $search_type=$request->has('type')?$request->get('type'):null;
        $articleserachincrease=$this->article_search($keyword);
        $searchdata=$this->keyword_search( $request,$keyword, $paginationNo, $search_type);
        return $this->sendApiSuccessResponse($searchdata, "search by text", 1);
    }

    public function lg_by_district($id)
    {
        $lg_list = LocalGovernment::where('district_id', $id)->get();
        return $this->sendApiSuccessResponse($lg_list, "local_government by district", 1);
    }
    public function district_by_province($id)
    {
        $districtlist = District::where('province_id', $id)->get();
        return $this->sendApiSuccessResponse($districtlist, "district by province", 1);
    }

    public function lg_details_by_num()
    {

            $electedofficialdata= DB::table('elected_officials')->paginate(10);
            $electedofficial=$electedofficialdata->total();
            $staffdata= DB::table('staffs')->paginate(10);
            $staff=$staffdata->total();
            $websitedirctorydata= DB::table('local_governments')->where('province_id', 5)->paginate(10);
            $websitedirctory=$websitedirctorydata->total();
            $documentdata= DB::table('lg_documents')->paginate(10);
            $documents=$documentdata->total();
            $servicedata= DB::table('services')->paginate(10);
            $services =$servicedata->total();
            $contactdata= DB::table('contacts')->paginate(10);
            $contacts =$contactdata->total();
            $articlesdata=DB::table('articles')->paginate(10);
            $articles=$articlesdata->total();
            $data = compact([ 'electedofficial', 'staff', 'websitedirctory', 'documents', 'services', 'contacts', 'articles']);
            return $this->sendApiSuccessResponse($data, "card_data", 1);

    }

//    public function lg_details_by_num()
//    {
//
//        $electedofficialdata = ElectedOfficials::all();
//        $electedofficial=count($electedofficialdata);
//
//        $staffdata = Staff::all();
//        $staff=count($staffdata);
//        $websitedirctorydata=LocalGovernment::all();
//        $websitedirctory=count($websitedirctorydata);
//        $documentsdata=Document::all();
//        $documents=count($documentsdata);
//         $services=Service::all()->count();
//         $contacts=Contact::all()->count();
//         $articles=Article::all()->count();
//        $data = compact([ 'electedofficial', 'staff', 'websitedirctory', 'documents']);
//        return $this->sendApiSuccessResponse($data, "card_data", 1);
//
//    }

    public function list_of_ministries(){
        $ministries=Ministry::all();
        return $this->sendApiSuccessResponse($ministries, "list of ministries", 1);
    }

    public function home_page_api($id){

      $local_governmant=LocalGovernment::find($id);
        if($local_governmant!=null) {
            $lg_name = $local_governmant->name;
            $lg_website=$local_governmant->website;
            $district = District::find($local_governmant->district_id);
            $district_name = $district->name;
            $contact_data = Contact::select('title', 'address', 'telephone', 'email')
                ->where('lg_id', $id)
                ->get();

            $representative = ElectedProfile::
                 select('title', 'photo', 'mobile', 'position')
                ->where('lg_id', $id)
                ->get()
                ->toArray();
            if ($representative === []) {
                $representative = ElectedOfficials::select('title', 'photo', 'phone', 'designation as position')
                    ->where('lg_id', $id)
                    ->limit(2)
                    ->get();

            }
            $lg_data = compact('lg_name','lg_website', 'district_name', 'contact_data', 'representative');
            return $this->sendApiSuccessResponse($lg_data, "map data");
        }

        else {
                return ["Result" => "lg does not exist"];
            }
        }

        public function map_data(Request $request){
        $district_id=$request->has('district_id')?$request->get('district_id'):null;
        $lg_id=$request->has('lg_id')?$request->get('lg_id'):null;
        if($district_id==null && $lg_id==null){
            $local_governments=LocalGovernment::where('province_id', 5)->count();
            $metropolitan=LocalGovernment::where('type', 'Metro')->where('province_id', 5)->count();
            $submetropolitan=LocalGovernment::where('type', 'Sub-Metro')->where('province_id', 5)->count();
            $municipality=LocalGovernment::where('type', 'Municipality')->where('province_id', 5)->count();
            $ruralmunicipality=LocalGovernment::where('type', 'Rural Mun')->where('province_id', 5)->count();
            $nationalpark=LocalGovernment::where('type', 'National Park')->where('province_id', 5)->count();
            $huntingreserve=LocalGovernment::where('type', 'Hunting Reserve')->where('province_id', 5)->count();
            $district=District::where('province_id', 5)->count();
            $totalwards=District::sum('ward_count');
            $population='4,499,272';
            $data=compact(['district','local_governments','metropolitan','submetropolitan','municipality','ruralmunicipality',
           'nationalpark', 'huntingreserve', 'totalwards', 'population']);
            return $this->sendApiSuccessResponse($data, "summary of map");

        }
        if($district_id!=null && $lg_id==null){
            $local_governments=LocalGovernment::where('province_id', 5)->where('district_id', $district_id)->count();
            $metropolitan=LocalGovernment::where('type', 'Metro')->where('province_id', 5)->where('district_id', $district_id)->count();
            $submetropolitan=LocalGovernment::where('type', 'Sub-Metro')->where('province_id', 5)->where('district_id', $district_id)->count();
            $municipality=LocalGovernment::where('type', 'Municipality')->where('province_id', 5)->where('district_id', $district_id)->count();
            $ruralmunicipality=LocalGovernment::where('type', 'Rural Mun')->where('province_id', 5)->where('district_id', $district_id)->count();
            $district=District::find($district_id);
            $totalwards=$district->ward_count;
            $district_name=$district->name;
            $population=$district->population;
            $data=compact('district_name','local_governments','metropolitan','submetropolitan','municipality','ruralmunicipality',
                'totalwards', 'population');
            return $this->sendApiSuccessResponse($data, "summary of map");

        }
        if(($district_id!=null && $lg_id!=null)||($district_id==null && $lg_id!=null)){
            $local_government=LocalGovernment::find($lg_id);
            $lg_name = $local_government->name_en;
            $lg_nep=$local_government->name;
            $lg_website=$local_government->website;
            $lg_official_email=$local_government->email;
            $lg_info_officer_email=$local_government->information_official_email;
            $district = District::find($local_government->district_id);
            $district_name = $district->name_en;
            $district_nep=$district->name;
            $contactdata =Contact::select('email', 'telephone')->where('lg_id', $lg_id)->get()->first();
            if($contactdata!=null) {
                $contactemails = explode(',', $contactdata->email);
                $email = $contactemails[0];
                $phone=$contactdata->telephone;
                $contact_data=compact('email', 'phone');
            }else{
                $contact_data="No data";
            }
//            $contact_data = Contact::select('title', 'address', 'telephone', 'email')
//                ->where('lg_id', $lg_id)
//                ->get();
            $mainposition=['Mayor','नगरप्रमुख','नगर प्रमुख','प्रमुख','अध्यक्ष','गा.पा.अध्यक्ष','गाउँपालिका अध्यक्ष'];
            $subposition=['उप प्रमुख','नगर उप प्रमुख','नगर उप-प्रमुख','उप– प्रमुख','नगर उप– प्रमुख','नगर उप-प्रमुख','नगर उप–प्रमुख','उपाध्यक्ष'];
            $rep1= ElectedOfficials::
            select('title', 'photo', 'phone', 'designation as position')
                ->where('lg_id', $lg_id)
                ->whereIn('designation', $mainposition)
                ->limit(1)
                ->first();

            $rep2=ElectedOfficials::
                select('title', 'photo', 'phone', 'designation as position')
                ->where('lg_id', $lg_id)
                ->whereIn('designation', $subposition)
                ->limit(1)
                ->first();
            $representative=[$rep1, $rep2];
            if($rep1==null && $rep2==null){
                $representative="No data";
            }
            if($rep1!=null && $rep2==null){
                $representative=ElectedOfficials::
                select('title', 'photo', 'phone', 'designation as position')
                    ->where('lg_id', $lg_id)
                    ->whereIn('designation', $mainposition)
                    ->limit(1)
                    ->get();
            }
            if($rep1==null && $rep2!=null){
                $representative=ElectedOfficials::
                select('title', 'photo', 'phone', 'designation as position')
                    ->where('lg_id', $lg_id)
                    ->whereIn('designation', $subposition)
                    ->limit(1)
                    ->get();
            }
            if($lg_id==50903){
                $representative=ElectedOfficials::
                select('title', 'photo', 'phone', 'designation as position')
                    ->where('lg_id', $lg_id)
                    ->limit(2)
                    ->get();

            }
            $lg_data = compact('lg_name','lg_nep','lg_website','lg_official_email','lg_info_officer_email', 'district_name','district_nep', 'contact_data', 'representative');
            return $this->sendApiSuccessResponse($lg_data, "map data");
        }

        }

    public function single_document(Request $request){
        $document_id=$request->get('document_id');
        $document=DB::table('lg_documents')
            ->select(["lg_documents.*", "local_governments.name as localgovernment_name", "local_governments.website as source"])
            ->join('local_governments', 'lg_documents.lg_id', '=', 'local_governments.id')
            ->where('lg_documents.id', $document_id)
            ->get();
        $single_doc=Document::find($document_id);
        $doc_type=$single_doc->document_type;
        $related_documents=DB::table('lg_documents')
            ->select(["lg_documents.*", "local_governments.name as localgovernment_name", "local_governments.website as source"])
            ->join('local_governments', 'lg_documents.lg_id', '=', 'local_governments.id')
            ->where('lg_documents.document_type', 'LIKE', '%'.$doc_type.'%')
            ->limit(10)
            ->get();
        $data=compact('document', 'related_documents');
        return $this->sendApiSuccessResponse($data, "Single document and related documents");
    }
     public function type_list(Request  $request){
        $type=$request->get('type');
        $lg_id=$request->has('lg_id')?$request->get('lg_id'):null;
         if (!in_array($type, [ 'website_directory','staff', 'document', 'service',  'elected_representative','article'])) {
             return 'type parameter is invalid';
         }
         if($type=='website_directory'){
             $type=DB::table('local_governments')->select('type as name')->distinct()->where('province_id', 5)->whereNotNull('type')->get();
             return $this->sendApiSuccessResponse($type, "lg type", 1);
         }
         if($type=='staff'){
             if($lg_id!=null) {
                 $designationlist = DB::Table('staffs')->select('designation as name')->where('lg_id', $lg_id)->distinct()->get();
                 return $this->sendApiSuccessResponse($designationlist, "designation list staff", 1);
             }
             else{
                 $designationlist = DB::Table('staffs')->select('designation as name')->distinct()->get();
                 return $this->sendApiSuccessResponse($designationlist, "designation list staff by lg", 1);

             }

         }
         if($type=='document'){
             if($lg_id!=null) {
                 $documenttypelist = DB::Table('lg_documents')->select('document_Type as name')->where('lg_id', $lg_id)->distinct()->get();
                 return $this->sendApiSuccessResponse($documenttypelist, "document type list", 1);
             }
             else{
                 $documenttypelist = DB::Table('lg_documents')->select('document_Type as name')->distinct()->get();
                 return $this->sendApiSuccessResponse($documenttypelist, "document type list by lg", 1);

             }
         }
         if($type=='service'){
             if ($lg_id!= null) {
                 $servicetypelist = DB::Table('services')->select('service_type as name')->where('lg_id', $lg_id)->distinct()->get();
                 return $this->sendApiSuccessResponse($servicetypelist, "service type list", 1);
             }
             else{
                 $servicetypelist = DB::Table('services')->select('service_type as name')->distinct()->get();
                 return $this->sendApiSuccessResponse($servicetypelist, "service type list", 1);

             }

         }
         if($type=='elected_representative'){
             if ($lg_id!= null) {
                 $designationlist = DB::table('elected_officials')->select('designation as name')->where('lg_id', $lg_id)->distinct()->get();
                 return $this->sendApiSuccessResponse($designationlist, "elected official designation list", 1);
             }
             else{
                 $designationlist = DB::table('elected_officials')->select('designation as name')->distinct()->get();
                 return $this->sendApiSuccessResponse($designationlist, " elected official designation list", 1);

             }

         }
         if($type=='article'){
             if ($lg_id!= null) {
                 $articles=DB::table('articles')->select('tags as name')->where('lg_id', $lg_id)->distinct()->get();
                 return $this->sendApiSuccessResponse($articles, "article  list", 1);
             }
             else{
                 $articles=DB::table('articles')->select('tags as name')->distinct()->get();
                 return $this->sendApiSuccessResponse($articles, "article  list", 1);

             }

         }


     }

     public function ministry_office_list(Request  $request){
        $ministry_id=$request->get('ministry_id');
        $ministry_office=DB::table('ministry_offices')
            ->join('ministries', 'ministries.id', '=', 'ministry_offices.ministry_id')
            ->where('ministry_offices.ministry_id', '=', $ministry_id)
            ->get(["ministry_offices.*","ministries.name as ministry_name"]);
         return $this->sendApiSuccessResponse($ministry_office, "ministry_office  list", 1);
     }

}
