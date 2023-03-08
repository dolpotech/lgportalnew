<?php

namespace App\Services\Api;


use App\HelperClasses\Traits\AuthHelper;
use App\HelperClasses\Traits\StorageHelper;
use App\Models\DocumentComment;
use App\Models\DocumentFieldComment;
use App\Models\InformationCollection;
use App\Models\InformationDocument;
use App\Models\InformationReceiver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\TableInsert;

class DocumentService
{
    use AuthHelper, StorageHelper;

    /**
     * Get Document Comments
     *
     * @param int $documentId
     * @return mixed
     */
    public function getDocumentComments(int $documentId)
    {
        return DocumentComment::where('document_id', $documentId)->get();
    }


    /**
     * Create Document
     *
     * @param int $informationId
     * @param int $fieldId
     * @param string $answer
     * @param string $document
     * @param string $reason
     * @return mixed
     */
    public function createDocument(int $informationId, int $fieldId, string $answer, string $document, string $reason)
    {
        return InformationDocument::create([
            'information_id'    => $informationId,
            'field_id'          => $fieldId,
            'answer'            => $answer,
            'document'          => $document,
            'reason'            => $reason,
            'status'            => getCompletedStatus()
        ]);
    }


    /**
     * Update Document Answer
     *
     * @param int $documentID
     * @param string $answer
     * @return mixed
     */
    public function updateDocumentAnswer(int $documentID, string $answer)
    {
        $informationDocument = InformationDocument::where('id', $documentID)->first();

        $informationDocument->answer = $answer;
        $informationDocument->save();

        return $informationDocument;
    }

    /**
     * Update Document
     *
     * @param int $infoReceiverId
     * @param $mainDocument
     * @param $supportingDocument
     * @return mixed
     */
    public function updateDocument(int $infoReceiverId, $mainDocument, $supportingDocument)
    {
        $previousDocuments = InformationDocument::where('info_receiver_id', $infoReceiverId)->get();

        foreach ($previousDocuments as $document) {
            $this->deleteDocumentFile($document->main_doc_path, $document->supporting_doc_path);
        }

        InformationDocument::where('info_receiver_id', $infoReceiverId)->delete();

        return $this->createDocumentType($infoReceiverId, $mainDocument, $supportingDocument);
    }

    /**
     *  Create Document Comment
     *
     * @param int $documentId
     * @param string $message
     * @return mixed
     */
    public function createDocumentComment(int $documentId, string $message)
    {
        return DocumentComment::create([
            'document_id'   => $documentId,
            'message'       => $message,
        ]);
    }


    /**
     *  Reply Document Comment
     *
     * @param int $commentId
     * @param string $message
     * @return mixed
     */
    public function replyDocumentComment(int $commentId, string $message)
    {
        return DocumentComment::where('id', $commentId)
            ->update([
                'reply'         => $message,
                'is_replied'    => 1,
            ]);
    }


    /**
     * Update Document
     *
     * @param int $infoReceiverId
     * @param int $fieldId
     * @param string $answer
     * @return mixed
     */
    public function createUpdateQuestionAnswer(int $infoReceiverId, int $fieldId, string $answer)
    {
        $document = InformationDocument::firstOrNew(array('info_receiver_id' => $infoReceiverId, 'field_id' => $fieldId));
        $document->answer = $answer;
        $document->save();

//        $infoReceiver = InformationReceiver::where('id', $infoReceiverId)->first();
//
//        $fieldCount = InformationCollection::join('templates','information_collection.template_id','templates.id')
//            ->join('template_fields','templates.id','template_fields.template_id')
//            ->where('information_collection.id', $infoReceiver->information_id)
//            ->count();

//        $documentCount = InformationDocument::where('info_receiver_id', $infoReceiverId)->count();
        // info receivers status to approve
//        if ($fieldCount == $documentCount){
//            InformationReceiver::where('id', $infoReceiverId)->update(['status' => getApprovalStatus()]);
//        }

        return $document;
    }

    /**
     * Create Document
     *
     * @param int $infoReceiverId
     * @param $mainDocument
     * @param $supportingDocument
     * @return mixed
     */
    public function createDocumentType(int $infoReceiverId, $mainDocument, $supportingDocument)
    {
        $information = InformationReceiver::where('id', $infoReceiverId)->first();
        $folder = $information->information_id.DIRECTORY_SEPARATOR.$infoReceiverId;
        $main_doc = $this->storeToDocument($mainDocument, $folder);

        if ($supportingDocument)
        {
            $supporting_doc = $this->storeToDocument($supportingDocument, $folder);
        }

        $document = InformationDocument::create([
            'info_receiver_id'      => $infoReceiverId,
            'main_doc'              => $main_doc['name'],
            'main_doc_path'         => $main_doc['path'],
            'main_doc_type'         => $main_doc['type'],
            'supporting_doc'        => $supporting_doc['name'] ?? null,
            'supporting_doc_path'   => $supporting_doc['path'] ?? null,
            'supporting_doc_type'   => $supporting_doc['type'] ?? null,
        ]);

//        InformationReceiver::where('id', $infoReceiverId)->update(['status' => getApprovalStatus()]);

        return $document;
    }

    /**
     *
     * @param int $documentId
     * @return mixed
     */
    public function getDocumentById(int $documentId)
    {
        return InformationDocument::find($documentId);
    }

    /**
     *
     * @param int $documentId
     * @return mixed
     */
    public function downloadInformationById(int $documentId)
    {
        return InformationDocument::find($documentId);
    }


    /**
     * Delete Document File On Update
     *
     * @return mixed
     */
    public function deleteDocumentFile($mainDocumentPath, $supportDocumentPath = '')
    {
        if ( File::exists(getStorageAppPath($mainDocumentPath)) ) {
            File::delete(getStorageAppPath($mainDocumentPath));
        }

        if ($supportDocumentPath) {
            if ( File::exists( getStorageAppPath($supportDocumentPath) ) ) {
                File::delete(getStorageAppPath($supportDocumentPath));
            }
        }
    }
}
