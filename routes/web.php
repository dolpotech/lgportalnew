<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LGController;
use App\Models\LocalGovernment;
use App\Models\Ministry;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Backend\TemplateController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('auth.login');
});

/*Route::get('/sms', function () {
    (new \App\Services\Api\NotificationService())->sendSms([9860357792], 'Hello Dhana G');
});*/


Route::get('/sliderdata', [LGController::class, 'getsliderdata']);
//Route::get('test', function () {
//    $lg = LocalGovernment::find(555);
//    dd($lg->users);
//    if ($lg = LocalGovernment::find(1)) {
//        dd(get_class($lg));
//    } elseif ($ministry = Ministry::find(1)) {
//        dd(get_class($ministry));
//    }
//    dd('jere');
//});

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::group(['middleware' => 'role:super_admin'], function () {
    Route::group(['prefix'=>'templates'], function(){
        Route::get('/index', [TemplateController::class, 'index'])->name('getAllTemplates');
        Route::get('/create', [TemplateController::class, 'createTemplate'])->name('createTemplates');
        Route::post('/store', [TemplateController::class, 'storeTemplate'])->name('storeTemplates');
        Route::get('/edit/{id}', [TemplateController::class, 'editTemplate'])->name('editTemplates');
        Route::post('/update', [TemplateController::class, 'updateTemplate'])->name('updateTemplates');
        Route::post('/update-template-field', [TemplateController::class, 'updateTemplateField'])->name('updateTemplateField');
        Route::post('/add-template-field', [TemplateController::class, 'addTemplateField'])->name('addTemplateField');
        Route::post('/delete/{id}', [TemplateController::class, 'deleteTemplateField'])->name('deleteTemplateField');
    });
    Route::group(['prefix' => 'users'], function (){
        Route::get('/index', [UserController::class, 'index'])->name('getAllUsers');
        Route::get('/getRoles', [UserController::class, 'getRoles'])->name('getRoles');
        Route::get('/getLgRoles', [UserController::class, 'getLgRoles'])->name('getLgRoles');
        Route::get('/getMinistryRoles', [UserController::class, 'getMinistryRoles'])->name('getMinistryRoles');
        Route::get('/getMinistryOfficeRoles', [UserController::class, 'getMinistryOfficeRoles'])->name('getMinistryOfficeRoles');
        Route::get('/getMinistryDepartmentRoles', [UserController::class, 'getMinistryDepartmentRoles'])->name('getMinistryDepartmentRoles');
        Route::get('/create', [UserController::class, 'createUser'])->name('createUser');
        Route::post('/storeUser', [UserController::class, 'storeUser'])->name('storeUser');
        Route::get('/edit/{id}', [UserController::class, 'editUser'])->name('editUser');
        Route::post('/updateUser', [UserController::class, 'updateUser'])->name('updateUser');
        Route::get('/delete/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
    });
});
