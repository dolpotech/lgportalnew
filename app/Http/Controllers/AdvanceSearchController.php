<?php

namespace App\Http\Controllers;

use App\HelperClasses\Traits\ApiResponse;
use App\Models\Contact;
use App\Models\ElectedOfficials;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdvanceSearchController extends Controller
{
    use ApiResponse;
    public function searchbycategory(Request $request){

        $search_by = $request->get('search_by');
        $pagination_number = $request->has('pagination_number') ? $request->get('pagination_number') : 12;

        if (!in_array($search_by, [ 'website_directory', 'staff', 'document', 'service', 'resource_map', 'contact', 'elected_representative','article'])) {
            $data =  collect([]);
        } else {
            $data = $this->searchQuery($request)
                ->paginate($pagination_number)
                ->appends($request->query());
        }

        return $this->sendApiSuccessResponse($data, "search result data", 1);
    }


    public function searchQuery(Request $request)
    {
        $search_by = $request->get('search_by');
        $district_id = $request->has('district_id') ? $request->get('district_id'):null;
        $lg_id = $request->has('lg_id') ? $request->get('lg_id') :null;
        $type = $request->has('type') ? $request->get('type') :null;
        $query = [];

        if ($search_by === 'website_directory') {
            $query = DB::table('local_governments')->select(["local_governments.*","districts.name_en as district","districts.name as district_nep"])
                ->join('districts', 'districts.id', '=', 'local_governments.district_id')
                ->where(function ($query) use ($district_id, $type, $lg_id) {
                    if ($type!=null ) {
                        $query->where('local_governments.type', '=', $type)
                            ->where('local_governments.province_id', '=', 5);
                    }
                    if ($district_id!=null) {
                        $query->where('local_governments.district_id', '=', $district_id)
                            ->where('local_governments.province_id', '=', 5);
                    }
                    if($lg_id!=null){
                        $query->where('local_governments.id', '=', $lg_id);

                    }
                });
        }

        if ($search_by === 'staff') {

            $query = Staff::select(["staffs.*", "local_governments.name as localgovernment_name", "local_governments.district_id"])
                ->join('local_governments', 'staffs.lg_id', '=', 'local_governments.id')
                ->where(function($query) use($district_id, $lg_id, $type){
                    if($type!=null) {
                        $query->where('staffs.designation', $type);
                    }
                    if($district_id!=null) {
                        $query->where('local_governments.district_id', $district_id);
                    }
                    if($lg_id!=null) {
                        $query->where('staffs.lg_id', $lg_id);
                    }
                });

        }

        if ($search_by === 'article') {
            $query= DB::table('articles')->select(["articles.*", "local_governments.name as localgovernment_name"])
                ->join('local_governments', 'articles.lg_id', '=', 'local_governments.id')
                ->where(function($query) use($district_id, $lg_id, $type){
                    if($type!=null  ) {
                        $query->where('articles.tags', $type);
                    }
                    if($district_id!=null){
                        $query->where('local_governments.district_id', '=', $district_id);
                    }

                    if( $lg_id!=null){
                        $query ->where('articles.lg_id', '=', $lg_id);
                    }

                });

        }
        if ($search_by === 'elected_representative') {
            $query= ElectedOfficials::select(["elected_officials.*", "local_governments.name as localgovernment_name"])
                ->join('local_governments', 'elected_officials.lg_id', '=', 'local_governments.id')
                ->where(function($query) use($district_id, $lg_id, $type){
                    if($type!=null ) {
                        $query->where('elected_officials.designation', $type);
                    }

                    if($district_id!=null ){
                        $query->where('local_governments.district_id', '=', $district_id);
                    }
                    if($lg_id!=null){
                        $query ->where('elected_officials.lg_id', '=', $lg_id);
                    }
                });

        }
        if ($search_by === 'document') {

            $query= DB::table('lg_documents')->select(["lg_documents.*", "local_governments.name as localgovernment_name"])
                ->join('local_governments', 'lg_documents.lg_id', '=', 'local_governments.id')
                ->where(function($query) use($district_id, $lg_id, $type){
                    if($type!=null ) {
                        $query->where('lg_documents.document_type', $type);
                    }
                    if($district_id!=null ){
                        $query->where('local_governments.district_id', '=', $district_id);
                    }
                    if( $lg_id!=null){
                        $query ->where('lg_documents.lg_id', '=', $lg_id);
                    }
                });

        }
        if ($search_by === 'service') {

            $query = DB::table('services')->select(["services.*", "local_governments.name as localgovernment_name"])
                ->join('local_governments', 'services.lg_id', '=', 'local_governments.id')
                ->where(function($query) use($district_id, $lg_id, $type){
                    if($type!=null) {
                        $query->where('services.service_type', $type);
                    }
                    if($district_id!=null){
                        $query->where('local_governments.district_id', '=', $district_id);
                    }
                    if( $lg_id!=null){
                        $query ->where('services.lg_id', '=', $lg_id);
                    }
                });

        }
        if ($search_by === 'resource_map') {
            $query = DB::table('resource_maps')
                ->select(["resource_maps.*", "local_governments.name as localgovernment_name"])
                ->join('local_governments', 'resource_maps.lg_id', '=', 'local_governments.id')
                ->where(function($query) use($district_id, $lg_id, $type){
                    if($district_id!=null ){
                        $query->where('local_governments.district_id', '=', $district_id);
                    }
                    if($lg_id!=null ) {
                        $query->where('local_governments.district_id', '=', $district_id)
                            ->where('resource_maps.lg_id', '=', $lg_id);
                    }
                });

        }

        if ($search_by === 'contact') {

            $query = Contact::select(["contacts.*", "local_governments.name as localgovernment_name"])
                ->join('local_governments', 'contacts.lg_id', '=', 'local_governments.id')
                ->where(function($query) use($district_id, $lg_id, $type){
                    if($type!=null) {
                        $query->where('contacts.title', $type);

                    }
                    if($district_id!=null ){
                        $query->where('local_governments.district_id', '=', $district_id);
                    }
                    if($lg_id!=null){
                        $query ->where('contacts.lg_id', '=', $lg_id);
                    }
                });
        }


        return $query;
    }
}
