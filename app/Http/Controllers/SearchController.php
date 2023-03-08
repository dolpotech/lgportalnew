<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\LocalGovernment;
use App\Models\Document;
use DB;
use App\Models\Staff;
use App\Models\Service;
use App\Models\Contact;
class SearchController extends Controller
{
    public function getallpradesh(){
        $province=Province::all();
        return response([
            'success' => true,
            'message' => "Province LIST",
            'data' => $province
            ], 200);
    }
    public function getalldistrict(){
        $districts=District::all();
        return response([
            'success' => true,
            'message' => "DISTRICT LIST",
            'data' => $districts
            ], 200);

    }



    public function getlgbydistrict($districtname){
        $districts=District::where('district_name', $districtname)->get();
        foreach($districts as $district){
            $id=$district->id;
        }
       $lgbydistrict=District::find($id)->lg;
        return response([
            'success' => true,
            'message' => "LOCALGOVERNMENT BY PRADESH",
            'data' =>$lgbydistrict
            ], 200);
    }



    public function getlgdata($id){
        $localgov=LocalGovernment::find($id);
        // $data=compact(['lg_name', 'lg_website','lg_type']);

        return response([
            'success' => true,
            'message' => "LOCALGOVERNMENT DATA FOR WEBSITE DIRCTORY",
            'data' =>  $localgov
            ], 200);

    }

    public function staffdata($id, Request $request){
        // $staffdata = \App\Models\Staff::with('localgovernment')->where('local_government_id', $id)->where('Designation', $request->designation)->get();
        // $staffdata=\App\Models\Staff::with(['localgov'])->get();
         $staffdata = DB::table('local_governments')
        ->join('staff', 'local_governments.id', '=','staff.local_government_id')
        ->where('staff.local_government_id', '=', $id)
        ->where('staff.Designation', $request->designation)
        ->get(["staff.*","local_governments.lg_name"]);
        return response([
            'success' => true,
            'message' => "List of staff data",
            'data' =>  $staffdata
            ], 200);
    }


    public function documentdetail($id,  Request $request){
        // $documentdetail=Document::where('lg_id', $id)->where('Document_Type', $request->documenttype)->get();
        $documentdetail= DB::table('local_governments')
        ->join('documents', 'local_governments.id', '=','documents.lg_id')
        ->where('documents.lg_id', '=', $id)
        ->where('documents.Document_Type', $request->documenttype)
        ->get(["documents.*","local_governments.lg_name"]);
        return response([
            'success' => true,
            'message' => "Document detail by document_type",
            'data' =>  $documentdetail
            ], 200);
    }
    public function servicetypelist($id){
        $servicetypelist=DB::Table('services')->select('Servicetype as name')->where('lg_id', $id)->distinct()->get();
        return response([
            'success' => true,
            'message' => "Service list by type",
            'data' => $servicetypelist
            ], 200);

    }

    public function servicedetailbytype($id, Request $request){
        // $servicedetail=Service::where('lg_id', $id)->where('Servicetype', $request->servicetype)->get();
        $servicedetail= DB::table('local_governments')
        ->join('services', 'local_governments.id', '=','services.lg_id')
        ->where('services.lg_id', '=', $id)
        ->where('services.Servicetype', $request->servicetype)
        ->get(["services.*","local_governments.lg_name"]);
        return response([
            'success' => true,
            'message' => "Service details by type",
            'data' => $servicedetail
            ], 200);

    }


    public function contactdetail($id, Request $request){
        $contactdetail= DB::table('local_governments')
        ->join('contacts', 'local_governments.id', '=','contacts.lg_id')
        ->where('contacts.lg_id', '=', $id)
        ->where('contacts.Title','LIKE','%'.$request->title.'%')
        ->get(["contacts.*","local_governments.lg_name"]);
        return response([
            'success' => true,
            'message' => "Contact Title list",
            'data' => $contactdetail
            ], 200);
    }

    public function wardofficial($id){
        $warddesignationlist=DB::Table('ward_officials')->select('Designation')->where('lg_id', $id)->distinct()->get();
        return response([
            'success' => true,
            'message' => "Ward designation list",
            'data' => $warddesignationlist
            ], 200);
    }

    public function wardofficedetail($id, Request $request){
        $wardofficedetail= DB::table('local_governments')
        ->join('ward_officials', 'local_governments.id', '=','ward_officials.lg_id')
        ->where('ward_officials.lg_id', '=', $id)
        ->where('ward_officials.Designation', $request->designation)
        ->get(["ward_officials.*","local_governments.lg_name"]);
        return response([
            'success' => true,
            'message' => "ward official detail  data",
            'data' => $wardofficedetail
            ], 200);

    }
    public function lgdata($id1, $districtid=null, $type=null){
    if($districtid!=null && $type!=null){
        $type1= str_replace('%20', ' ', $type);
        // $districts=District::where('district_name', $district)->get();
        // foreach($districts as $district){
        //     $id=$district->id;
        // }
        // $localgovernment = \App\Models\LocalGovernment::with(['district'])->get();
        // $localgovernmentbyType=$localgovernment->where('district_id', $id)
        // ->where('lg_type', $type);
        $localgovernmentbyType = DB::table('local_governments')
        ->join('districts', 'districts.id', '=', 'local_governments.district_id')
        ->where('local_governments.district_id', '=', $districtid)
        ->where('local_governments.lg_type', '=', $type1)
        ->get(["local_governments.*","districts.district_name"]);
        return response([
            'success' => true,
            'message' => "LOCAL GOVERNMENT LIST",
            'data' =>  $localgovernmentbyType
            ], 200);
    }

    elseif($type==null && $districtid!=null){
        // $districts=District::where('district_name', $district)->get();
        // foreach($districts as $district){
        //     $id=$district->id;
        // }
    // $lgbydistrict=District::find($id)->lg;
    $lgbydistrict = DB::table('local_governments')
        ->join('districts', 'districts.id', '=', 'local_governments.district_id')
        ->where('local_governments.district_id', '=', $districtid)
        ->get(["local_governments.*","districts.district_name"]);
        return response([
            'success' => true,
            'message' => "LOCALGOVERNMENT BY District name",
            'data' =>$lgbydistrict
            ], 200);


    }
    else{
        $lgbydistrict = DB::table('local_governments')
        ->join('districts', 'districts.id', '=', 'local_governments.district_id')
        ->get(["local_governments.*","districts.district_name"]);
        return response([
            'success' => true,
            'message' => "LOCALGOVERNMENT BY District name",
            'data' =>$lgbydistrict
            ], 200);

}
}
    public function searchbykeyword($search=null){
        if(is_null($search)) {
            $results_empty= true;
            return response()->json(["status" => 404, "Message"=> "Please Enter text to search"]);

        }

        else {
              $results2 = Document::where('Language', 'like', "%$search%")
                  ->orWhere('Title', 'like', "%$search%")
                  ->orWhere('Body', 'like', "%$search%")
                  ->orWhere('Document_Type', 'like', "%$search%")
                  ->orWhere('Documents', 'like', "%$search%")
                  ->orWhere('image', 'like', "%$search%")
                  ->get()
                  ->toArray();
                if($results2){
                    return response()->json(["status" => 200, "Search Results"=> $results2, "message"=>"document data"]);
                }
                else{
                    return response()->json(["status" => 400, "Search Results"=> "No data found"]);
                }


        }
    }
    public function searchstaffkeyword($keyword){
        if(is_null($keyword)) {
            $results_empty= true;
            return response()->json(["status" => 404, "Message"=> "Please Enter text to search"]);

        }

        else {
              $results2 = Document::where('Language', 'like', "%$keyword%")
                  ->orWhere('Title', 'like', "%$keyword%")
                  ->orWhere('Body', 'like', "%$keyword%")
                  ->orWhere('Designation', 'like', "%$keyword%")
                  ->orWhere('Email', 'like', "%$keyword%")
                  ->orWhere('Phone', 'like', "%$keyword%")
                  ->orWhere('Photo', 'like', "%$keyword%")
                  ->orWhere('PostBox', 'like', "%$keyword%")
                  ->orWhere('Section', 'like', "%$keyword%")
                  ->orWhere('Tenure', 'like', "%$keyword%")
                  ->orWhere('Responsibility', 'like', "%$keyword%")
                  ->get()
                  ->toArray();
                if($results2){
                    return response()->json(["status" => 200, "Search Results"=> $results2, "message"=>"document data"]);
                }
                else{
                    return response()->json(["status" => 400, "Search Results"=> "No data found"]);
                }


        }

    }

    public function searchservicekeyword($keyword){
        if(is_null($keyword)) {
            $results_empty= true;
            return response()->json(["status" => 404, "Message"=> "Please Enter text to search"]);

        }

        else {
              $results2 = Service::where('Title', 'like', "%$keyword%")
                  ->orWhere('Language', 'like', "%$keyword%")
                  ->orWhere('Servicetype', 'like', "%$keyword%")
                  ->orWhere('Servicetime', 'like', "%$keyword%")
                  ->orWhere('ResponsibleOfficer', 'like', "%$keyword%")
                  ->orWhere('ServiceOffice', 'like', "%$keyword%")
                  ->orWhere('ServiceFee', 'like', "%$keyword%")
                  ->orWhere('RequiredDocuments', 'like', "%$keyword%")
                  ->orWhere('RelatedDocuments', 'like', "%$keyword%")
                  ->orWhere('Process', 'like', "%$keyword%")
                  ->orWhere('Body', 'like', "%$keyword%")
                  ->get()
                  ->toArray();
                if($results2){
                    return response()->json(["status" => 200, "Search Results"=> $results2, "message"=>"document data"]);
                }
                else{
                    return response()->json(["status" => 400, "Search Results"=> "No data found"]);
                }

    }
}
}
