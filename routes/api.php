<?php

use App\Events\SendMail;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LGController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DataFetchController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Rolemanagement;
use App\Http\Controllers\AdvanceSearchController;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\InformationCommentController;
use App\Http\Controllers\ArticleController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [LoginController::class, 'login'])->name('login');
/*Route::post('test-sms', function () {
    echo ((new \App\Services\Api\NotificationService())->sendSms([9860357792], 'good'));
});*/
//    Information Collection
Route::get('files/information/main-doc/{id}',            [InformationController::class,     'getMainDocumentForInformation'])->name('file.information.main_doc');
Route::get('download-files/information/main-doc/{id}',   [InformationController::class,     'downloadMainDocumentForInformation'])->name('download-file.information.main_doc');
Route::get('files/information/supporting-doc/{id}',      [InformationController::class,     'getSupportingDocumentForInformation'])->name('file.information.supporting_doc');
Route::get('download-files/information/supporting-doc/{id}', [InformationController::class,     'downloadSupportingDocumentForInformation'])->name('download-file.information.supporting_doc');

//    Document
Route::get('files/document/main-doc/{id}',          [DocumentController::class,     'getMainDocumentForDocument'])->name('file.document.main_doc');
Route::get('download-files/document/main-doc/{id}',   [DocumentController::class,     'downloadMainDocumentForDocument'])->name('download-file.document.main_doc');
Route::get('files/document/supporting-doc/{id}',    [DocumentController::class,     'getSupportingDocumentForDocument'])->name('file.document.supporting_doc');
Route::get('download-files/document/supporting-doc/{id}', [DocumentController::class,     'downloadSupportingDocumentForDocument'])->name('download-file.document.supporting_doc');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['middleware' => 'role:super_admin,ministry_admin'], function () {
        Route::get('templates/all',     [TemplateController::class, 'getAllTemplates'])->name('getAllTemplates');
    });

    Route::group(['middleware' => 'role:super_admin'], function () {
        Route::post('templates/create', [TemplateController::class, 'storeTemplate'])->name('createTemplates');
        Route::post('templates/update', [TemplateController::class, 'updateTemplate'])->name('updateTemplate');
    });

    Route::group(['middleware' => 'role:ministry_admin'], function () {
        Route::post('ministry/user/create',         [UserController::class, 'createMinistryUser'])->name('ministry.user.create');
        Route::post('ministry/user/update',         [UserController::class, 'updateMinistryUser'])->name('ministry.user.update');
        Route::get('ministry/user/list',            [UserController::class, 'getMinistryUsers'])->name('ministry.user.list');
        Route::get('ministry/user/roles',           [UserController::class, 'getMinistryRoles'])->name('ministry.user.roles');
        Route::get('ministry/get/lg-officers',      [UserController::class, 'getLgOfficers'])->name('ministry.get_lg_officers');
        Route::get('ministry/get/ministry-officers',[UserController::class, 'getMinistryOfficers'])->name('ministry.get_ministry_officers');

        Route::post('ministry/information/create',          [InformationController::class, 'createNewCollection'])->name('ministry.information.create');
        Route::post('ministry/information/update',          [InformationController::class, 'updateNewCollection'])->name('ministry.information.update');
        Route::get('get/ministry-office/for-information-create',[InformationController::class, 'getMinistryOfficeInformation'])->name('ministry.information.get.ministry_office');

        Route::get('ministry/information/comment-user-list', [InformationCommentController::class, 'getCommentUsersListForMinistry'])->name('ministry.information.comment_user_list');
        Route::get('ministry/information/comment-list',      [InformationCommentController::class, 'getCommentListForLgMinistry'])->name('ministry.information.comment_user_list');
        Route::post('ministry/information/create-comment',   [InformationCommentController::class, 'replyInformationCommentByMinistryAdmin'])->name('ministry.information.reply_comment');
        Route::get('ministry-admin/information/list',        [InformationController::class,   'getInformationForMinistryAdmin'])->name('ministry_admin.information.list');
        Route::get('ministry-admin/information/detail',      [InformationController::class,   'getInformationDetailForMinistryAdmin'])->name('ministry_admin.information.detail');

        Route::get('ministry-admin/assigned-user/list',      [InformationController::class,   'getAssignedUserInformationListForMinistryAdmin'])->name('ministry_admin.assigned_user.information.list');
        Route::get('ministry-admin/assigned-user/detail',    [InformationController::class,   'getAssignedUserInformationDetailForMinistryAdmin'])->name('ministry_admin.assigned_user.information.detail');

        Route::get('ministry/information-collection/report', [InformationController::class,   'getInformationCollectionReportForMinistry'])->name('ministry.information-collection.report');

        Route::post('ministry/ministry-office/create',      [UserController::class,  'createMinistryOffice'])->name('ministry-office.create');
        Route::post('ministry/ministry-office/update',      [UserController::class,  'updateMinistryOffice'])->name('ministry-office.update');
        Route::get('ministry/ministry-office/list',         [UserController::class,  'listMinistryOffices'])->name('ministry-office.list');

        Route::get('ministry/total-information',            [InformationController::class, 'getTotalInformationForMinistryAdmin'])->name('ministry.total_information');

        Route::get('ministry/get/information-collection',   [InformationController::class, 'getInformationCollection'])->name('get.information-collection');
    });

    Route::group(['middleware' => 'role:ministry_officer,ministry_cao'], function () {
        Route::post('ministry/document/update',             [DocumentController::class, 'updateDocumentByMinistryOfficer'])->name('ministry.document.update');
        Route::post('ministry/document/create',             [DocumentController::class, 'createDocumentByMinistryOfficer'])->name('ministry.document.create');
        Route::post('ministry/question-answer/create',      [DocumentController::class, 'createQuestionAnswerByMinistryOfficer'])->name('ministry.question-answer.create');
    });

    Route::group(['middleware' => 'role:ministry_officer'], function () {
        Route::post('ministry/document/reply-comment', [DocumentController::class, 'replyCommentOnDocumentForMinistry'])->name('ministry.document.reply_comment');
    });

    Route::group(['middleware' => 'role:ministry_cao'], function () {
        Route::post('ministry/document/create-comment',    [DocumentController::class,    'createCommentOnDocumentForMinistry'])->name('ministry.document.create_comment');
    });

    Route::group(['middleware' => 'role:ministry_admin,ministry_officer,ministry_cao'], function () {
        Route::get('ministry/information/list',                         [InformationController::class,   'getInformationForMinistry'])->name('ministry.information.list');
        Route::get('ministry/information/detail',                       [InformationController::class,   'getInformationDetailForMinistry'])->name('ministry.information.detail');
        Route::get('ministry/information-collection/detail',            [InformationController::class, 'getInformationCollectionDetailForMinistry'])->name('ministry.information_collection.detail');
        Route::get('ministry/notifications',                            [NotificationController::class, 'getMinistryNotification'])->name('ministry.notification');
    });

    Route::group(['middleware' => 'role:lg_admin'], function () {
        Route::get('local-gov/user/list',       [UserController::class, 'getLgUsers'])->name('lg_admin.user.list');
        Route::get('local-gov/user/roles',      [UserController::class, 'getLgRoles'])->name('lg_admin.user.roles');
        Route::post('local-gov/user/create',    [UserController::class, 'createLgUser'])->name('lg_admin.create.user');
        Route::post('local-gov/user/update',    [UserController::class, 'updateLgUser'])->name('lg_admin.update.user');

        Route::get('local-gov/information/comment-list',      [InformationCommentController::class,  'getCommentListForLgAdmin'])->name('lg_admin.comment.list');
        Route::post('local-gov/information/start-processing', [InformationController::class, 'startProcessingInformationByLgAdmin'])->name('lg.information.start_processing');
    });

    Route::group(['middleware' => 'role:ministry_admin,ministry_officer,ministry_cao,lg_admin,lg_cao,lg_officer,mo_admin,mo_cao,mo_officers'], function () {
        Route::post('information/create-comment',    [InformationCommentController::class,  'createCommentOnInformation'])->name('information.create_comment');
    });

    Route::group(['middleware' => 'role:lg_admin,lg_cao,lg_officer'], function () {
        Route::get('local-gov/information/list',                [InformationController::class, 'getInformationForLg'])->name('lg.information.list');
        Route::get('local-gov/information/detail',              [InformationController::class, 'getInformationDetailForLg'])->name('lg.information.detail');
        Route::get('local-gov/information-collection/detail',   [InformationController::class, 'getInformationCollectionDetailForLg'])->name('lg.information_collection.detail');
        Route::get('local-gov/notifications',                   [NotificationController::class, 'getLgNotification'])->name('lg.notification');
        Route::get('local-gov/total-information',               [InformationController::class, 'getTotalInformationForLgAdmin'])->name('lg.total_information');
    });

    Route::group(['middleware' => 'role:lg_officer,lg_cao'], function () {
        // Route::get('local-gov/document/comment-list',     [ DocumentController::class, 'getDocumentFieldCommentsForLg'])->name('lg.document_field.comments');
    });

    Route::group(['middleware' => 'role:lg_officer,lg_cao'], function () {
        Route::post('local-gov/question-answer/create', [DocumentController::class, 'createQuestionAnswerByLgOfficer'])->name('lg.template.create');
        Route::post('local-gov/document/create',        [DocumentController::class, 'createDocumentByLgOfficer'])->name('lg.document.create');
        Route::post('local-gov/document/update',        [DocumentController::class, 'updateDocumentByLgOfficer'])->name('lg.document.update');
    });

    Route::group(['middleware' => 'role:lg_officer'], function () {
        Route::post('local-gov/document/reply-comment', [DocumentController::class, 'replyCommentOnDocument'])->name('lg.document.reply_comment');
    });

    Route::group(['middleware' => 'role:lg_cao,ministry_cao,mo_cao'], function () {
        Route::post('information/complete',       [InformationController::class, 'setInformationCompletedByCao'])->name('information.set_completed');
    });

    Route::group(['middleware' => 'role:lg_cao'], function () {
        Route::post('local-gov/document/create-comment',    [DocumentController::class,    'createCommentOnDocumentForLg'])->name('lg.document.create_comment');
        Route::post('local-gov/information/approve',        [InformationController::class, 'setInformationApprovedByCao'])->name('lg.information.approve');
    });

    Route::group(['middleware' => 'role:mo_admin'], function () {
        Route::get('ministry-office/user/list',        [UserController::class, 'getMinistryOfficeUsers'])->name('mo_admin.user.list');
        Route::get('ministry-office/user/roles',       [UserController::class, 'getMinistryOfficeRoles'])->name('mo_admin.user.roles');
        Route::post('ministry-office/user/create',     [UserController::class, 'createMinistryOfficeUser'])->name('mo_admin.create.user');
        Route::post('ministry-office/user/update',     [UserController::class, 'updateMinistryOfficeUser'])->name('mo_admin.update.user');
    });

    Route::group(['middleware' => 'role:mo_admin,mo_cao,mo_officers'], function () {
        Route::get('ministry-office/information/list',                [InformationController::class, 'getInformationForMinistryOffice'])->name('ministry-office.information.list');
        Route::get('ministry-office/information/detail',              [InformationController::class, 'getInformationDetailForMinistryOffice'])->name('ministry-office.information.detail');
        Route::get('ministry-office/information-collection/detail',   [InformationController::class, 'getInformationCollectionDetailForMinistryOffice'])->name('ministry-office.information_collection.detail');
        Route::get('ministry-office/notifications',                   [NotificationController::class, 'getMinistryOfficeNotification'])->name('ministry-office.notification');
        Route::get('ministry-office/total-information',               [InformationController::class, 'getTotalInformationForMinistryOfficeAdmin'])->name('mo.total_information');
    });

    Route::group(['middleware' => 'role:mo_cao,mo_officers'], function () {
        Route::post('ministry-office/question-answer/create', [DocumentController::class, 'createQuestionAnswerByMinistryOfficeOfficer'])->name('mo.question-answer.create');
        Route::post('ministry-office/document/update',        [DocumentController::class, 'updateDocumentByMoOfficer'])->name('mo.document.update');
        Route::post('ministry-office/document/create',        [DocumentController::class, 'createDocumentByMoOfficer'])->name('mo.document.create');
    });

    Route::group(['middleware' => 'role:mo_officers'], function () {
        Route::post('ministry-office/document/reply-comment', [DocumentController::class, 'replyCommentOnDocumentForMO'])->name('mo.document.reply_comment');
    });

    Route::group(['middleware' => 'role:mo_cao'], function () {
        Route::post('ministry-office/document/create-comment',    [DocumentController::class,    'createCommentOnDocumentForMO'])->name('mo.document.create_comment');
    });


});






Route::middleware(['auth:sanctum', 'RoleValidation:lg_admin'])->get('/user', function (Request $request) {
    return $request->user();
});
// get lgfilters in one api
Route::get('/getlgdata/{id1}/{districtid?}/{lgid?}/{type?}', [SearchController::class, 'lgdata']);
Route::get('/getlocalgovernmentbypradesh/{id}', [LGController::class, 'getLGByPradesh']);
Route::get('/getlocalgovernmentbydistrict/{id1}/{id2}', [LGController::class, 'getLGByDistrict']);
Route::get('/getlocalgovernmentbytype/{id2}/{type}', [LGController::class, 'getLGByType']);
// api for inserting data in database
//api for fetching data from database
//Staff-api
Route::get('/getstaffdata', [DataFetchController::class, 'getstaffdata']);
//Document-api
Route::get('/getdocumentlist', [DataFetchController::class, 'getdocument']);
// Wards-api
Route::get('/getwarddata', [DataFetchController::class, 'getwarddata']);
//Gallery-api
Route::get('/getgalleryphoto', [DataFetchController::class, 'getphotodata']);
//Resource-map-api
Route::get('/resourcemapdata', [DataFetchController::class, 'getresourcemapdata']);
//Service-api
Route::get('/servicedata', [DataFetchController::class, 'getservicedata']);
//Contact-api
Route::get('/contactdata', [DataFetchController::class, 'getcontactdata']);
// Ward-Officials-api
Route::get('/wardofficialsdata', [DataFetchController::class, 'getwardofficialsdata']);
// Elected-Profile-api
Route::get('/electedprofiledata', [DataFetchController::class, 'getelectedprofiledata']);
// Important-Place-api
Route::get('/importantplacedata', [DataFetchController::class, 'getimportantplacedata']);
//elected officials api
Route::get('/electedofficialdata', [DataFetchController::class, 'getelectedofficialdata']);
// slider-api
Route::get('/sliderdata', [DataFetchController::class, 'getsliderdata']);
//inserting the data into local government
//Route::post('/insertlocalgovernment', [LGController::class, 'insert']);
//Route::delete('deletelocalgovernment/{id}', [LGController::class, 'delete']);

//routes for advanced search section
Route::get('allpradesh', [SearchController::class, 'getallpradesh']);
Route::get('alldistrict', [SearchController::class, 'getalldistrict']);
Route::get('/alllocalgovernment', [LGController::class, 'getAllLG']);
//Route::get('getlgbydistrict/{districtname}', [SearchController::class, 'getlgbydistrict']);
//WEBSITE DIRECTORY
Route::get('getspecificlgdata/{id}', [SearchController::class, 'getlgdata']);
Route::get('getspecificlgdatabyname/{dname}', [SearchController::class, 'getlgdatabyname']);

// ELECTED REPRESENTATIVE/ STAFF
Route::get('designationliststaff/{id}', [SearchController::class, 'designationlist']);
Route::get('staffdetaibydesignation/{id}', [SearchController::class, 'staffdata']);

//Document Search
Route::get('getdocumenttypelist/{id}', [SearchController::class, 'documenttypelist']);
Route::get('getdocumentdetailbytype/{id}', [SearchController::class, 'documentdetail']);


// SERVICE TYPE LIST
Route::get('getservicetypelist/{id}', [SearchController::class, 'servicetypelist']);
Route::get('servicedetailbytype/{id}', [SearchController::class, 'servicedetailbytype']);

//Telephone Directory
Route::get('contacttitlelist/{id}', [SearchController::class, 'contacttitlelist']);
Route::get('contactdetailbytitle/{id}', [SearchController::class, 'contactdetail']);
Route::get('wardofficialdesignation/{id}', [SearchController::class, 'wardofficial']);
Route::get('wardofficialdetail/{id}', [SearchController::class, 'wardofficedetail']);

//Search api
//document Search
//Staff Search
Route::get('/staffdatasearchbytext/{keyword?}', [SearchController::class, 'searchstaffkeyword']);
// service Search
Route::get('/servicesearchbytext/{keyword?}', [SearchController::class, 'searchservicekeyword']);

//public apis
Route::get('/getdistrictlist', [DataController::class, 'getdistrictbypradesh']);
Route::get('/getlglist', [DataController::class, 'getAllLG']);
Route::get('designationliststaff', [DataController::class, 'designationlist']);
Route::get('getdocumenttypelist', [DataController::class, 'documenttypelist']);
Route::get('getservicetypelist', [DataController::class, 'servicetypelist']);
Route::get('electedofficialsdesignation', [DataController::class, 'elected_official_designation']);
Route::get('contacttitlelist', [DataController::class, 'contacttitlelist']);
Route::get('getlgrelateddata', [AdvanceSearchController::class, 'searchbycategory']);
Route::get('getlgbydistrict/{district_id}',[DataController::class,'lg_by_district']);
Route::get('articletaglist', [DataController::class, 'article_tag_list']);
Route::get('getdistrictbyprovince/{province_id}', [DataController::class, 'district_by_province']);

//total number of lg
Route::get('/totalnumberoflg', [DataController::class, 'number_of_lg']);
Route::get('/staffcount/{lg_id}', [DataController::class, 'number_of_staff']);
Route::get('totalwards/{lg_id}', [DataController::class, 'number_of_wards']);
Route::get('totalelectedrepresentative/{lg_id}', [DataController::class, 'total_number_of_elected_officials']);
Route::get('lgdetails/{lg_id}', [DataController::class, 'lg_details']);
Route::get('card_data',[DataController::class, 'lg_details_by_num']);


Route::get('/staff/{lg_id}', [DataController::class, 'staff_data_lg']);
Route::get('documentdata/{lg_id}', [DataController::class, 'document_data']);
Route::get('elected_officials/{lg_id}', [DataController::class, 'elected_official']);
Route::get('articles/{lg_id}', [DataController::class, 'articles']);
Route::get('searchbytext', [DataController::class, 'search_keyword'])->name('search');
Route::get('listofministries', [DataController::class, 'list_of_ministries']);
Route::get('homepagedata/{lg_id}', [DataController::class, 'home_page_api']);


Route::get('articlelist/{lg_id?}', [ArticleController::class, 'list_of_article']);
Route::post('articleincreament-view/{article_id}', [ArticleController::class, 'view_increament']);
Route::post('articleincerament-search/{article_id}', [ArticleController::class, 'search_increment']);
Route::get('mostviewedarticle', [ArticleController::class, 'most_viewed']);
Route::get('mostsearchedarticle', [ArticleController::class, 'most_searched']);
Route::get('newarticles', [ArticleController::class, 'new_article']);
Route::get('ministryoffice', [DataController::class, 'ministry_office_list']);

Route::get('getallarticle', [ArticleController::class, 'article_list']);
Route::get('getsinglearticle',[ArticleController::class, 'single_article']);

Route::get('getmapdata', [DataController::class, 'map_data']);

Route::get('singledocument', [DataController::class, 'single_document']);
Route::get('typelist', [DataController::class, 'type_list']);

Route::get('/exportexcel', [\App\Http\Controllers\ExportController::class, 'export_data']);

