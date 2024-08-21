<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SlideUneController;
use App\Http\Controllers\TypeEventController;
use App\Http\Controllers\NewsLettersController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\TermsAndPolicyController;

Route::group([
    'prefix' => 'v1.0'
], function () {
    Route::get('/welcome', function () {
        return response()->json([
            'User'=> 'Welcome sur l\'api de la caci 🍀',
        ]);
    });
});


Route::group([
    'prefix' => 'v1.0',
    // 'middleware' => 'auth:api'
], function () {
    Route::post('/login', [AuthController::class, 'logIn']);
    Route::post('/refresh_token', [AuthController::class, 'refreshToken']);
    Route::get('/logout/{id}', [AuthController::class, 'logOut']);
    Route::get('/reset_old_connection', [AuthController::class, 'resetOldConnection']);
    Route::get('/check_old_connection', [AuthController::class, 'checkOldConnection']);
});


//💫🍎 START 💫🍎--*$*__*$*--💫🍎 //
//💫🍎 --*$*__*$*-- 💫🍎 FRONTEND 💫🍎--*$*__*$*--💫🍎 //
Route::group([
    // 'middleware' => 'api',
    'prefix' => 'v1.0',
    // 'middleware' => 'auth:api'
], function () {

    // --*$*__*$*-- 💫🍎 START NEWSLETTERS ROUTES 💫🍎--*$*__*$*-- //
    Route::post('/add_new_newsletter', [NewsLettersController::class, 'store']);
    Route::get('/get__frontend__all_data', [FrontendController::class, 'get_frontent_data']);
    // 💫🍎 END NEWSLETTERS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //

});
//💫🍎 --*$*__*$*-- 💫🍎 FRONTEND 💫🍎--*$*__*$*--💫🍎 //
//💫🍎--*$*__*$*--💫🍎 END 💫🍎 //



//💫🍎 START 💫🍎--*$*__*$*--💫🍎 //
//💫🍎 --*$*__*$*-- 💫🍎 BACKEND 💫🍎--*$*__*$*--💫🍎 //

Route::group([
    // 'middleware' => 'api',
    'prefix' => 'v1.0',
    'middleware' => 'auth:api'
], function () {

    // --*$*__*$*-- 💫🍎 START RÔLE ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_role', [RoleController::class, 'index']);
        Route::post('/add_new_role', [RoleController::class, 'store']);
        Route::put('/update_current_role/{slg}', [RoleController::class, 'update']);
        Route::delete('/delete_current_role/{slg}', [RoleController::class, 'delete']);
    // 💫🍎 END RÔLE ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START ADMIN ACCOUNT ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_admin_accounts', [AdminAccountController::class, 'index']);
        Route::post('/add_new_admin_account', [AdminAccountController::class, 'store']);
        Route::post('/update_current_admin_account/{slg}', [AdminAccountController::class, 'update']);
        Route::put('/check_status_current_admin_account/{slg}', [AdminAccountController::class, 'checked']);
        Route::delete('/delete_current_admin_account/{slg}', [AdminAccountController::class, 'delete']);
    // // 💫🍎 END ADMIN ACCOUNT ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START NEWSLETTERS ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_newsletters', [NewsLettersController::class, 'index']);
        Route::put('/update_current_newsletter/{slg}', [NewsLettersController::class, 'update']);
        Route::delete('/delete_current_newsletter/{slg}', [NewsLettersController::class, 'delete']);
    // 💫🍎 END NEWSLETTERS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START SLIDE UNE ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_slide_une', [SlideUneController::class, 'index']);
        Route::post('/add_new_slide_une', [SlideUneController::class, 'store']);
        Route::post('/update_current_slide_une/{slg}', [SlideUneController::class, 'update']);
        Route::delete('/delete_current_slide_une/{slg}', [SlideUneController::class, 'delete']);
    // // 💫🍎 END SLIDE UNE ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START TYPE EVENT ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_type_events', [TypeEventController::class, 'index']);
        Route::post('/add_new_type_event', [TypeEventController::class, 'store']);
        Route::put('/update_current_type_event/{slg}', [TypeEventController::class, 'update']);
        Route::delete('/delete_current_type_event/{slg}', [TypeEventController::class, 'delete']);
    // // 💫🍎 END TYPE EVENT ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START EVENT ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_events', [EventController::class, 'index']);
        Route::post('/add_new_event', [EventController::class, 'store']);
        Route::put('/update_current_event/{slg}', [EventController::class, 'update']);
        Route::delete('/delete_current_event/{slg}', [EventController::class, 'delete']);
    // // 💫🍎 END EVENT ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START TEAMS ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_persons', [TeamsController::class, 'index']);
        Route::post('/add_new_person', [TeamsController::class, 'store']);
        Route::post('/update_current_person/{slg}', [TeamsController::class, 'update']);
        Route::delete('/delete_current_person/{slg}', [TeamsController::class, 'delete']);
    // // 💫🍎 END TEAMS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START PARTNERS ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_partners', [PartnersController::class, 'index']);
        Route::post('/add_new_partner', [PartnersController::class, 'store']);
        Route::post('/update_current_partner/{slg}', [PartnersController::class, 'update']);
        Route::delete('/delete_current_partner/{slg}', [PartnersController::class, 'delete']);
    // // 💫🍎 END PARTNERS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //

    // // --*$*__*$*-- 💫🍎 START TERMS AND POLICYS ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_terms_and_policys', [TermsAndPolicyController::class, 'index']);
        Route::post('/add_new_terms_and_policy', [TermsAndPolicyController::class, 'add']);
        Route::put('/update_current_terms_and_policy/{slg}', [TermsAndPolicyController::class, 'update']);
        Route::delete('/delete_current_terms_and_policy/{slg}', [TermsAndPolicyController::class, 'delete']);
    // // 💫🍎 END PARTNERS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //

});
//💫🍎 --*$*__*$*-- 💫🍎 BACKEND 💫🍎--*$*__*$*--💫🍎 //
//💫🍎--*$*__*$*--💫🍎 END 💫🍎 //
