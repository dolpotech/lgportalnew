<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Staff;
use App\Models\Document;
use App\Models\Ward;
use App\Models\Gallery;
use App\Models\ResourceMap;
use App\Models\Contact;
use App\Models\WardOfficials;
use App\Models\ImportantPlaces;
use App\Models\ElectedOfficials;
use App\Models\Service;
use App\Models\ElectedProfile;

class DataFetchController extends Controller
{
    public function getstaffdata(){
        $staffs=Staff::all();
        return response([
            'success' => true,
            'message' => "STAFF LIST",
            'data' => $staffs
            ], 200);
    }

    public function getdocument(){
        $documents=Document::all();
        return response([
            'success' => true,
            'message' => "DOCUMENT LIST",
            'data' => $documents
            ], 200);

    }

    public function getwarddata(){
        $wards=Ward::all();
        return response([
            'success' => true,
            'message' => "WARD INFO",
            'data' => $wards
            ], 200);


    }

    public function getphotodata(){
        $galleries=Gallery::all();
        return response([
            'success' => true,
            'message' => "GALLERY INFO",
            'data' => $galleries
            ], 200);
    }
    public function getresourcemapdata(){
        $resourcemaps=ResourceMap::all();
        return response([
            'success' => true,
            'message' => "Resource Map INFO",
            'data' => $resourcemaps
            ], 200);
    }
    public function getservicedata(){
        $services=Service::all();
        return response([
            'success' => true,
            'message' => "SERVICE DATA",
            'data' => $services
            ], 200);

    }
    public function getcontactdata(){
        $contacts=Contact::all();
        return response([
            'success' => true,
            'message' => "CONTACT DATA",
            'data' => $contacts
            ], 200);

    }
    public function getwardofficialsdata(){
        $wardofficials=WardOfficials::all();
        return response([
            'success' => true,
            'message' => "WARD OFFICIAL DATA",
            'data' => $wardofficials
            ], 200);
    }
    public function getelectedprofiledata(){
        $electedprofiles=ElectedProfile::all();
        return response([
            'success' => true,
            'message' => "ELECTED PROFILE DATA",
            'data' => $electedprofiles
            ], 200);

    }
    public function getimportantplacedata(){
        $implaces=ImportantPlaces::all();
        return response([
            'success' => true,
            'message' => "IMPORTANT PLACE DATA",
            'data' => $implaces
            ], 200);
    }
    public function getelectedofficialdata(){
        $electedofficials=ElectedOfficials::all();
        return response([
            'success' => true,
            'message' => "ELECTED OFFICIAL DATA",
            'data' => $electedofficials
            ], 200);
    }
    public function getsliderdata(){
        $sliders=Slider::all();
        return response([
            'success' => true,
            'message' => "SLIDER DATA",
            'data' => $sliders
            ], 200);
    }
}
