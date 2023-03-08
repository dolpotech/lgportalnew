<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
use App\Models\LocalGovernment;


class LGController extends Controller
{
    public function getAllLG()
    {
        $local_government = \App\Models\LocalGovernment::with(['pradesh', 'district'])->get();
        return response([
            'success' => true,
            'message' => "LOCAL GOVERNMENT LIST",
            'data' => $local_government
        ], 200);
    }

    public function getLGByPradesh($id)
    {
        $localgovernment = \App\Models\LocalGovernment::with(['pradesh', 'district'])->get();
        $localgovernmentbypradesh = $localgovernment->where('pradesh_id', $id);

        return response([
            'success' => true,
            'message' => "LOCAL GOVERNMENT LIST",
            'data' => $localgovernmentbypradesh
        ], 200);
        // $localgovernment = DB::table('pradeshes')
        // ->join('districts', 'pradeshes.id', '=', 'districts.pradesh_id')
        // ->join('local_governments', 'local_governments.pradesh_id', '=', 'pradeshes.id')
        // ->where('pradeshes.id', '=', $id)
        // ->get();
    }

    public function getLGByDistrict($id1, $id2)
    {
        $localgovernment = \App\Models\LocalGovernment::with(['pradesh', 'district'])->get();
        $localgovernmentbyPradeshandDistrict = $localgovernment->where('pradesh_id', $id1)->where('district_id', $id2);
        // $localgovernment = DB::table('local_governments')
        // ->join('pradeshes', 'local_governments.pradesh_id', '=', 'pradeshes.id')
        // ->join('districts', 'districts.pradesh_id', '=', 'pradeshes.id')
        // ->where('pradeshes.id', '=', $id1)
        // ->where('districts.id', '=', $id2)
        // ->get();
        return response([
            'success' => true,
            'message' => "LOCAL GOVERNMENT LIST",
            'data' => $localgovernmentbyPradeshandDistrict
        ], 200);
    }

    public function getLGByType($id2, $type)
    {
        $localgovernment = \App\Models\LocalGovernment::with(['district'])->get();
        $localgovernmentbyType = $localgovernment->where('district_id', $id2)
            ->where('lg_type', $type);
        return response([
            'success' => true,
            'message' => "LOCAL GOVERNMENT LIST",
            'data' => $localgovernmentbyType
        ], 200);
    }

    public function getsliderdata()
    {
        $slider = Http::get('https://sunwalmun.gov.np/slider-api')->json();
        return view('slider')->with([
            'sliders' => $slider
        ]);
    }
}

//    public function insert(){
//       $data=[
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'58',
//            'lg_name'=>'Bardaghat Municipality',
//            'lg_website'=>'http://bardghatmun.gov.np/',
//            'lg_type'=>'Municipality',
//           ],
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'58',
//            'lg_name'=>'Ramgram Municipality',
//            'lg_website'=>'https://ramgrammun.gov.np/',
//            'lg_type'=>'Municipality',
//           ],
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'58',
//            'lg_name'=>'Sunwal Municipality',
//            'lg_website'=>'https://sunwalmun.gov.np/',
//            'lg_type'=>'Municipality',
//           ],
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'58',
//            'lg_name'=>'Susta village municipality',
//            'lg_website'=>'https://sustamun.gov.np/',
//            'lg_type'=>'Village municipality',
//           ],
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'58',
//            'lg_name'=>'Palhinandan village municipality',
//            'lg_website'=>'http://palhinandanmun.gov.np/',
//            'lg_type'=>'Village municipality',
//           ],
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'58',
//            'lg_name'=>'Pratappur village municipality',
//            'lg_website'=>'http://pratappurmun.gov.np/',
//            'lg_type'=>'Village municipality',
//           ],
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'58',
//            'lg_name'=>'Sarawal village municipality',
//            'lg_website'=>'http://sarawalmun.gov.np/',
//            'lg_type'=>'Village municipality',
//           ],
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'59',
//            'lg_name'=>'Putha Uttarganga village municipality',
//            'lg_website'=>'https://puthauttargangamun.gov.np/',
//            'lg_type'=>'Village municipality',
//           ],
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'59',
//            'lg_name'=>'Bhume village municipality',
//            'lg_website'=>'http://bhumemun.gov.np/',
//            'lg_type'=>'Village municipality',
//           ],
//           [
//            'pradesh_id' => '5',
//            'district_id'=>'59',
//            'lg_name'=>'Sisne village municipality',
//            'lg_website'=>'http://sisnemun.gov.np/',
//            'lg_type'=>'Village municipality',
//           ],
//            ];
//
//            $result=LocalGovernment::insert($data);
//            return ["Result"=>"data inserted"];
//    }

//    public function delete($id){
//        $localgovernment=LocalGovernment::find($id);
//        $localgovernment->delete();
//        return ["Result"=>"Data deleted"];
//
//    }
//}
