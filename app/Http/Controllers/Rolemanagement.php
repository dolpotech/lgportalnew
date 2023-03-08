<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userroles;
use App\Models\SuperAdmin;
use App\Models\Users;
use App\Models\Lginformationofficer;
use App\Models\CAO;
use App\Models\LocalGovernment;
use App\Models\District;
use Illuminate\Support\Facades\Hash;
use DB;

class Rolemanagement extends Controller
{
    public function getuserrole($id){
        $userrole=userroles::find($id);
        $userrole=DB::Table('userroles')->select('user_role')->where('id', $id)->get();
        return response([
            'success' => true,
            'message' => "User Role by type",
            'data' => $userrole
            ], 200);
    }

    public function allusertype(){
        $usertype=userroles::select('id','user_type')->get();
        return response([
            'success' => true,
            'message' => "User Role by type",
            'data' => $usertype
            ], 200);

    }



}

