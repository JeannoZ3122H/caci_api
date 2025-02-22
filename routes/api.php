<?php

use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DelegationsController;
use App\Http\Controllers\FaqKeywordController;
use App\Http\Controllers\FonctionController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MotDuPresidentController;
use App\Http\Controllers\ObjectContactController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\OrganisationBannerController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CvController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\messageController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MissionsController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SlideUneController;
use App\Http\Controllers\TypeEventController;
use App\Http\Controllers\ActualitesController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\RessourcesController;
use App\Http\Controllers\NewsLettersController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\OrganisationsController;
use App\Http\Controllers\TypesServicesController;
use App\Http\Controllers\InfosPratiquesController;
use App\Http\Controllers\ReseauxSociauxController;
use App\Http\Controllers\TermsAndPolicyController;
use App\Http\Controllers\TypeProcedureController;
use App\Http\Controllers\SociauxController;
use App\Mail\sendMyMail;

Route::group([], function () {
    Route::get('/welcome', function () {
        return 'Welcome to caci api 🍀';
    });
    // Route::get('/send-email-test', function () {
    //     Mail::to('macosretina2015@gmail.com')
    //     ->send(new sendMyMail());
    //     // Mail::to('recipient@example.com')->send(new sendMyMail());
    // });
});

// Route::options('{any}', function () {
//     return response('', 200)
//     ->header('Access-Control-Allow-Origin', '*')
//     ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
//     ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
// })->where('any', '.*');



Route::group([
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
    // 'prefix' => 'v1.0',
    // 'middleware' => 'auth:api'
], function ($routes) {
// --*$*__*$*-- 💫🍎 START FRONTENT ROUTES 💫🍎--*$*__*$*-- //

    // --*$*__*$*-- 💫🍎 START SESSIONS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontend__all__session__list', [FrontendController::class, 'get_frontent_session_list']);
    // --*$*__*$*-- 💫🍎 START NAVBAR ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontend__special__patner', [FrontendController::class, 'get__frontend__special__patner']);

    // --*$*__*$*-- 💫🍎 START CONTACT US ROUTES 💫🍎--*$*__*$*-- //
    Route::post('/store__frontent__contact__us', [FrontendController::class, 'store__contact__us']);
    Route::post('/follow__my__folder__send__by__code__ref', [FrontendController::class, 'follow_my_folder']);
    // --*$*__*$*-- 💫🍎 START NEWSLETTERS ROUTES 💫🍎--*$*__*$*-- //
    Route::post('/add_new_newsletter', [NewsLettersController::class, 'store']);
    // --*$*__*$*-- 💫🍎 START ARCHIVES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontend__archives', [FrontendController::class, 'get_archives']);
    Route::get('/get__frontend__details__archives/{month}/{year}', [FrontendController::class, 'get_details_archives']);
    // --*$*__*$*-- 💫🍎 START WELCOME ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontend__all_data', [FrontendController::class, 'get_frontent_data']);
    // --*$*__*$*-- 💫🍎 START COMMENTS ROUTES 💫🍎--*$*__*$*-- //
    Route::post('/store__frontent__comments', [FrontendController::class, 'store__comments']);
    // --*$*__*$*-- 💫🍎 START EVENTS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontend__current__event__details/{slug}', [FrontendController::class, 'current__event__details']);
    Route::get('/get__frontent__list__events', [FrontendController::class, 'get__list__events']);
    // --*$*__*$*-- 💫🍎 START ABOUT ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontent__content_historique', [FrontendController::class, 'content_historique']);
    Route::get('/get__frontent__content_organisation', [FrontendController::class, 'content_organisation']);
    Route::get('/get__frontent__content_list_organisation', [FrontendController::class, 'content_list_organisation']);
    Route::get('/get__frontent__current_organisation_content/{code_org}', [FrontendController::class, 'details_current_organisation']);
    Route::get('/get__frontent__current_person_mi_protfolio_content/{slug}', [FrontendController::class, 'get_mi_portfolio_content']);
    Route::get('/get__frontent__content_mission', [FrontendController::class, 'content_mission']);
    Route::get('/get__frontent__content_mot_du_president', [FrontendController::class, 'content_mot_du_president']);
    Route::get('/get__frontent__content_delegation', [FrontendController::class, 'content_delegation']);
    Route::get('/get__frontent__current__content__delegation/{slug}', [FrontendController::class, 'content_current_delegation']);
    Route::get('/get__frontent__content_partner', [FrontendController::class, 'content_partner']);
    // --*$*__*$*-- 💫🍎 START RESSOURCES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontent__content_publication', [FrontendController::class, 'content_publication']);
    // --*$*__*$*-- 💫🍎 START SERVICES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontent__content_service/{type_service_id}', [FrontendController::class, 'content_service']);
    // --*$*__*$*-- 💫🍎 START TYPES SERVICES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontent__list__type__services', [FrontendController::class, 'get__list__type__service']);
    Route::get('/get__frontent__current__type__service__by__code/{code}', [FrontendController::class, 'get__current__type__service']);
    // --*$*__*$*-- 💫🍎 START ACTUALITES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontent__content__agenda', [FrontendController::class, 'content__agenda']);
    Route::get('/get__frontent__type_events__from__content__agenda', [FrontendController::class, 'get__type_events__from__content__agenda']);
    // Route::get('/get__frontent__current__type__service__by__code/{code}', [FrontendController::class, 'get__current__type__service']);
    // --*$*__*$*-- 💫🍎 START INFORMATIONS PRATIQUES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get__frontent__faqs', [FrontendController::class, 'get_faq']);
    Route::post('/store__frontent__faq', [FrontendController::class, 'store_faq']);
    Route::get('/get__frontent__content__info_pratique', [FrontendController::class, 'content__info_pratique']);
    Route::get('/get__frontent__current__info_pratique__by__code/{code}', [FrontendController::class, 'get__current__document__join']);
    Route::get('/get__frontent__current__info_pratique__details/{type}', [FrontendController::class, 'get__current__type__content']);
    // Devenir
    Route::get('/get__frontent__devenir', [FrontendController::class, 'get_devenir']);
    Route::get('/get__frontent__list_countries', [FrontendController::class, 'get_list_countries']);
    Route::get('/get__frontent__list_professions', [FrontendController::class, 'get_list_professions']);
    Route::get('/get__frontent__list_fonctions', [FrontendController::class, 'get_list_fonctions']);
    //
    Route::get('/get__frontend__search__all__collection', [FrontendController::class, 'get_frontend_search_all_collection']);
    // Soumettre Docs
    Route::get('/get__frontent__soumettre__docs', [FrontendController::class, 'get_soumettre_docs']);
    Route::post('/fetch__in__list__frontent__soumettre__docs__by__code__ref', [FrontendController::class, 'fetch_soumettre_docs_by__code__ref']);
    // Calculator frais
    Route::get('/get__frontent__calculators__frais', [FrontendController::class, 'get_calculators_frais']);
    // Lien Utile
    Route::get('/get__frontent__lien_utile', [FrontendController::class, 'get_lien_utile']);
    // Members
    Route::get('/get__frontent__list_members', [FrontendController::class, 'get_list_members']);
    // Terms And Policys
    Route::get('/get_terms_and_policys', [FrontendController::class, 'get_terms_and_policys']);
    // Banners
    Route::get('/get_list_banners', [FrontendController::class, 'get_list_banners']);
    // Reseau Social
    Route::get('/get_reseau_social', [FrontendController::class, 'get_reseau_social']);
    // Contact Object
    Route::get('/get__frontent__content_contact_object', [FrontendController::class, 'get_contact_object']);
    // Faq Keyword
    Route::get('/get__frontent__content_faq_keyword', [FrontendController::class, 'get_faq_keyword']);
    Route::get('/get__frontent__content_faq', [FrontendController::class, 'get_faq']);

    // Session Management
    Route::get('/get_frontent_session_service', [FrontendController::class, 'get_session_service']);
    Route::get('/get_frontent_session_event', [FrontendController::class, 'get_session_event']);
    Route::get('/get_frontent_session_teams', [FrontendController::class, 'get_session_teams']);
    Route::get('/get_frontent_session_partners', [FrontendController::class, 'get_session_partners']);
    Route::get('/get_frontent_session_delegations', [FrontendController::class, 'get_session_delegations']);
    // 💫🍎 END FRONTENT ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START STATISTIQUES ROUTES 💫🍎--*$*__*$*-- //
    Route::post('/store__frontent__content_statistique', [StatisticsController::class, 'store_web_app_statistics']);
    // --*$*__*$*-- 💫🍎 START STATISTIQUES ROUTES 💫🍎--*$*__*$*-- //
});
//💫🍎 --*$*__*$*-- 💫🍎 FRONTEND 💫🍎--*$*__*$*--💫🍎 //
//💫🍎--*$*__*$*--💫🍎 END 💫🍎 //



//💫🍎 START 💫🍎--*$*__*$*--💫🍎 //
//💫🍎 --*$*__*$*-- 💫🍎 BACKEND 💫🍎--*$*__*$*--💫🍎 //

Route::group([
    'middleware' => 'api',
    // 'prefix' => 'v1.0',
    // 'middleware' => 'auth:api'
], function () {

    // --*$*__*$*-- 💫🍎 START STATISTIQUES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_all_statistics_web_app', [StatisticsController::class, 'data_all_statistics_web_app']);
    // --*$*__*$*-- 💫🍎 START STATISTIQUES ROUTES 💫🍎--*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START RÔLE ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_role', [RoleController::class, 'index']);
        Route::post('/add_new_role', [RoleController::class, 'store']);
        Route::put('/update_current_role/{slg}', [RoleController::class, 'update']);
        Route::get('/delete_current_role/{slg}', [RoleController::class, 'delete']);
    // 💫🍎 END RÔLE ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START ADMIN ACCOUNT ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_admin_accounts', [AdminAccountController::class, 'index']);
        Route::post('/add_new_admin_account', [AdminAccountController::class, 'store']);
        Route::post('/update_current_admin_account/{slg}', [AdminAccountController::class, 'update']);
        Route::get('/check_status_current_admin_account/{slg}', [AdminAccountController::class, 'checked']);
        Route::get('/delete_current_admin_account/{slg}', [AdminAccountController::class, 'delete']);
    // // 💫🍎 END ADMIN ACCOUNT ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START SLIDE UNE ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_slide_une', [SlideUneController::class, 'index']);
        Route::post('/add_new_slide_une', [SlideUneController::class, 'store']);
        Route::post('/update_current_slide_une/{slg}', [SlideUneController::class, 'update']);
        Route::get('/delete_current_slide_une/{slg}', [SlideUneController::class, 'delete']);
        Route::put('/change_current_slide_une_order/{slg}', [SlideUneController::class, 'change_item_order']);
    // // 💫🍎 END SLIDE UNE ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START TYPE EVENT ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_type_events', [TypeEventController::class, 'index']);
        Route::post('/add_new_type_event', [TypeEventController::class, 'store']);
        Route::put('/update_current_type_event/{slg}', [TypeEventController::class, 'update']);
        Route::get('/delete_current_type_event/{slg}', [TypeEventController::class, 'delete']);
        Route::put('/change_current_type_event_order/{slg}', [TypeEventController::class, 'change_item_order']);
    // // 💫🍎 END TYPE EVENT ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START EVENT ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_events', [EventController::class, 'index']);
        Route::post('/add_new_event', [EventController::class, 'store']);
        Route::post('/update_current_event/{slg}', [EventController::class, 'update']);
        Route::get('/delete_current_event/{slg}', [EventController::class, 'delete']);
        Route::put('/change_current_event_order/{slg}', [EventController::class, 'change_item_order']);
    // // 💫🍎 END EVENT ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START TEAMS ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_persons', [TeamsController::class, 'index']);
        Route::post('/add_new_person', [TeamsController::class, 'store']);
        Route::post('/update_current_person/{slg}', [TeamsController::class, 'update']);
        Route::get('/delete_current_person/{slg}', [TeamsController::class, 'delete']);
        Route::put('/change_current_person/{slg}', [TeamsController::class, 'change_item_order']);
    // // 💫🍎 END TEAMS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START CV ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_current_cv_content_list/{matricule}', [CvController::class, 'index']);
        Route::get('/check_person_cv_content_exist/{matricule}', [CvController::class, 'check']);
        Route::post('/add_new_content_in_cv', [CvController::class, 'store']);
        Route::post('/update_current_content_in_cv/{slg}', [CvController::class, 'update']);
        Route::get('/delete_current_content_in_cv/{slg}', [CvController::class, 'delete']);
    // // 💫🍎 END CV ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // // --*$*__*$*-- 💫🍎 START PARTNERS ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_partners', [PartnersController::class, 'index']);
        Route::post('/add_new_partner', [PartnersController::class, 'store']);
        Route::post('/update_current_partner/{slg}', [PartnersController::class, 'update']);
        Route::get('/delete_current_partner/{slg}', [PartnersController::class, 'delete']);
        Route::put('/change_current_partner_order/{slg}', [PartnersController::class, 'change_item_order']);
        Route::put('/status_declared_partner_into_favorite/{slg}', [PartnersController::class, 'declared_partner_into_favorite']);
    // // 💫🍎 END PARTNERS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //

    // // --*$*__*$*-- 💫🍎 START TERMS AND POLICYS ROUTES 💫🍎--*$*__*$*-- //
        Route::get('/get_list_terms_and_policys', [TermsAndPolicyController::class, 'index']);
        Route::post('/add_new_terms_and_policys', [TermsAndPolicyController::class, 'store']);
        Route::post('/update_current_terms_and_policys/{slg}', [TermsAndPolicyController::class, 'update']);
        Route::get('/delete_current_terms_and_policys/{slg}', [TermsAndPolicyController::class, 'delete']);
    // // 💫🍎 END PARTNERS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START MISSIONS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_missions', [MissionsController::class, 'index']);
    Route::post('/add_new_mission', [MissionsController::class, 'store']);
    Route::post('/update_current_mission/{slg}', [MissionsController::class, 'update']);
    Route::get('/delete_current_mission/{slg}', [MissionsController::class, 'delete']);
    // 💫🍎 END MISSIONS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START ORGANISATIONS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_organisations', [OrganisationsController::class, 'index']);
    Route::get('/get_list_countries', [OrganisationsController::class, 'index_country']);
    Route::get('/get_list_professions', [OrganisationsController::class, 'index_profession']);
    Route::get('/get_list_competence', [OrganisationsController::class, 'index_competence']);
    Route::post('/add_new_organisation', [OrganisationsController::class, 'store']);
    Route::post('/update_current_organisation/{slg}', [OrganisationsController::class, 'update']);
    Route::get('/delete_current_organisation/{slg}', [OrganisationsController::class, 'delete']);
    Route::put('/change_current_organisation_order/{slg}', [OrganisationsController::class, 'change_item_order']);
    // 💫🍎 END ORGANISATIONS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START HISTORIQUES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_historiques', [HistoriqueController::class, 'index']);
    Route::post('/add_new_historique', [HistoriqueController::class, 'store']);
    Route::post('/update_current_historique/{slg}', [HistoriqueController::class, 'update']);
    Route::get('/delete_current_historique/{slg}', [HistoriqueController::class, 'delete']);
    // 💫🍎 END HISTORIQUES ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START TYPES PUBLICATIONS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_type_publications', [RessourcesController::class, 'index_type_publication']);
    Route::post('/add_new_type_publication', [RessourcesController::class, 'store_type_publication']);
    Route::post('/update_current_type_publication/{slg}', [RessourcesController::class, 'update_type_publication']);
    Route::get('/delete_current_type_publication/{slg}', [RessourcesController::class, 'delete_type_publication']);
    // 💫🍎 END TYPES PUBLICATIONS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START PUBLICATIONS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_publications', [RessourcesController::class, 'index_publication']);
    Route::post('/add_new_publication', [RessourcesController::class, 'store_publication']);
    Route::post('/update_current_publication/{slg}', [RessourcesController::class, 'update_publication']);
    Route::get('/delete_current_publication/{slg}', [RessourcesController::class, 'delete_publication']);
    // 💫🍎 END PUBLICATIONS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START LIENS UTILES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_lien_utiles', [RessourcesController::class, 'index_lien_utile']);
    Route::post('/add_new_lien_utile', [RessourcesController::class, 'store_lien_utile']);
    Route::post('/update_current_lien_utile/{slg}', [RessourcesController::class, 'update_lien_utile']);
    Route::get('/delete_current_lien_utile/{slg}', [RessourcesController::class, 'delete_lien_utile']);
    // 💫🍎 END LIENS UTILES ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START AGENDAS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_agendas', [ActualitesController::class, 'index_agenda']);
    Route::post('/add_new_agenda', [ActualitesController::class, 'store_agenda']);
    Route::post('/update_current_agenda/{slg}', [ActualitesController::class, 'update_agenda']);
    Route::get('/delete_current_agenda/{slg}', [ActualitesController::class, 'delete_agenda']);
    // 💫🍎 END AGENDAS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START TYPE SERVICES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_type_services', [TypesServicesController::class, 'index']);
    Route::post('/add_new_type_service', [TypesServicesController::class, 'store']);
    Route::post('/update_current_type_service/{slg}', [TypesServicesController::class, 'update']);
    Route::get('/delete_current_type_service/{slg}', [TypesServicesController::class, 'delete']);
    Route::put('/change_current_type_service_order/{slg}', [TypesServicesController::class, 'change_item_order']);
    // 💫🍎 END TYPE SERVICES ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START SERVICES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_type_service_list/{type_service_id}', [ServicesController::class, 'index']);
    Route::post('/add_new_service', [ServicesController::class, 'store']);
    Route::post('/update_current_service/{slg}', [ServicesController::class, 'update']);
    Route::get('/delete_current_service/{slg}', [ServicesController::class, 'delete']);
    // 💫🍎 END SERVICES ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START PROFESSIONS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_profession_list', [ProfessionController::class, 'index']);
    Route::post('/add_new_profession', [ProfessionController::class, 'store']);
    Route::post('/update_current_profession/{slg}', [ProfessionController::class, 'update']);
    Route::get('/delete_current_profession/{slg}', [ProfessionController::class, 'delete']);
    // 💫🍎 END PROFESSIONS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START PAYS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_country_list', [CountryController::class, 'index']);
    Route::post('/add_new_country', [CountryController::class, 'store']);
    Route::post('/update_current_country/{slg}', [CountryController::class, 'update']);
    Route::get('/delete_current_country/{slg}', [CountryController::class, 'delete']);
    // 💫🍎 END PAYS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START LANGUAGES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_language_list', [LanguageController::class, 'index']);
    Route::post('/add_new_language', [LanguageController::class, 'store']);
    Route::post('/update_current_language/{slg}', [LanguageController::class, 'update']);
    Route::get('/delete_current_language/{slg}', [LanguageController::class, 'delete']);
    // 💫🍎 END LANGUAGES ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START COMPETENCES ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_competence_list', [CompetenceController::class, 'index']);
    Route::post('/add_new_competence', [CompetenceController::class, 'store']);
    Route::post('/update_current_competence/{slg}', [CompetenceController::class, 'update']);
    Route::get('/delete_current_competence/{slg}', [CompetenceController::class, 'delete']);
    // 💫🍎 END COMPETENCES ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START FONCTIONS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_fonction_list', [FonctionController::class, 'index']);
    Route::post('/add_new_fonction', [FonctionController::class, 'store']);
    Route::post('/update_current_fonction/{slg}', [FonctionController::class, 'update']);
    Route::get('/delete_current_fonction/{slg}', [FonctionController::class, 'delete']);
    // 💫🍎 END FONCTIONS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START TESTIMONIALS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_testimonial_list', [TestimonialsController::class, 'index']);
    Route::post('/add_new_testimonial', [TestimonialsController::class, 'store']);
    Route::put('/update_current_testimonial/{slg}', [TestimonialsController::class, 'update']);
    Route::get('/delete_current_testimonial/{slg}', [TestimonialsController::class, 'delete']);
    // 💫🍎 END TESTIMONIALS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START BANNERS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_banner_list', [BannerController::class, 'index']);
    Route::post('/add_new_banner', [BannerController::class, 'store']);
    Route::post('/update_current_banner/{slg}', [BannerController::class, 'update']);
    Route::get('/delete_current_banner/{slg}', [BannerController::class, 'delete']);
    Route::put('/change_current_banner_order/{slg}', [BannerController::class, 'change_item_order']);
    // 💫🍎 END BANNERS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START RESEAUX SOCIAUX ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_reseaux_sociaux_list', [ReseauxSociauxController::class, 'index']);
    Route::post('/add_new_reseaux_sociaux', [ReseauxSociauxController::class, 'store']);
    Route::post('/update_current_reseaux_sociaux/{slg}', [ReseauxSociauxController::class, 'update']);
    Route::get('/delete_current_reseaux_sociaux/{slg}', [ReseauxSociauxController::class, 'delete']);
    Route::put('/change_current_reseaux_sociaux_order/{slg}', [ReseauxSociauxController::class, 'change_item_order']);
    // 💫🍎 END RESEAUX SOCIAUX ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START SOCIAUX ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_sociaux_list', [SociauxController::class, 'index']);
    Route::post('/add_new_sociaux', [SociauxController::class, 'store']);
    Route::post('/update_current_sociaux/{slg}', [SociauxController::class, 'update']);
    Route::get('/delete_current_sociaux/{slg}', [SociauxController::class, 'delete']);
    Route::put('/change_current_sociaux_order/{slg}', [SociauxController::class, 'change_item_order']);
    // 💫🍎 END SOCIAUX ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START CONTACT US AND NEWSLETTERS ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_messagerie_list', [NewsLettersController::class, 'index']);
    Route::post('/confirm_read_current_message/{slg}', [NewsLettersController::class, 'confirm_read']);
    Route::put('/update_current_messagerie_for_start_traitment/{slg}', [NewsLettersController::class, 'update']);
    Route::get('/delete_current_messagerie/{id}/{nbre}', [NewsLettersController::class, 'delete']);
    Route::put('/check_status_current_messagerie/{slg}/{nbre}', [NewsLettersController::class, 'check']);
    // 💫🍎 END CONTACT US AND NEWSLETTERS ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START FOLDERS US ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_folders_us', [messageController::class, 'index']);
    Route::post('/store_new_folders_us', [messageController::class, 'store']);
    // Route::post('/update_current_folders_us/{slg}', [messageController::class, 'update']);
    Route::post('/update_current_folders_us_status_analyse/{slg}', [messageController::class, 'update']);
    Route::get('/delete_current_folders_us/{slg}', [messageController::class, 'delete']);
    Route::put('/check_status_answere_current_folders_us/{slg}', [messageController::class, 'check']);
    Route::put('/check_status_current_folders_us/{slg}', [messageController::class, 'finished']);
// 💫🍎 END FOLDERS US ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START TYPE PROCEDURE ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_list_type_procedure', [TypeProcedureController::class, 'index']);
    Route::post('/add_new_type_procedure', [TypeProcedureController::class, 'store']);
    Route::put('/update_current_type_procedure/{slg}', [TypeProcedureController::class, 'update']);
    Route::get('/delete_current_type_procedure/{slg}', [TypeProcedureController::class, 'delete']);
    // 💫🍎 END TYPE PROCEDURE ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START ANALYSE FOLDER ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_messagerie_old_list_analyse/{ref_dossier}', [messageController::class, 'get_old_list_analyse']);
    // 💫🍎 END ANALYSE FOLDER ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START PRESENTATIONS US ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_presentation_list', [PresentationController::class, 'index']);
    Route::post('/add_new_presentation', [PresentationController::class, 'store']);
    Route::post('/update_current_presentations/{id}', [PresentationController::class, 'update']);
    Route::get('/delete_current_presentation/{slg}', [PresentationController::class, 'delete']);
    Route::put('/change_current_presentation_order/{slg}', [PresentationController::class, 'change_item_order']);
    // 💫🍎 END PRESENTATIONS US ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START MOT DU PRESIDENT ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_mot_du_president_list', [MotDuPresidentController::class, 'index']);
    Route::post('/add_new_mot_du_president', [MotDuPresidentController::class, 'store']);
    Route::post('/update_current_mot_du_president/{id}', [MotDuPresidentController::class, 'update']);
    Route::get('/delete_current_mot_du_president/{slg}', [MotDuPresidentController::class, 'delete']);
    Route::put('/change_current_mot_du_president_order/{slg}', [MotDuPresidentController::class, 'change_item_order']);
    // 💫🍎 END MOT DU PRESIDENT ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


    // --*$*__*$*-- 💫🍎 START DELEGATION ROUTES 💫🍎--*$*__*$*-- //
    Route::get('/get_current_delegation_list', [DelegationsController::class, 'index']);
    Route::post('/add_new_delegation', [DelegationsController::class, 'store']);
    Route::post('/update_current_delegation/{slg}', [DelegationsController::class, 'update']);
    Route::get('/delete_current_delegation/{slg}', [DelegationsController::class, 'delete']);
    Route::put('/change_current_delegation_order/{slg}', [DelegationsController::class, 'change_item_order']);
    // 💫🍎 END DELEGATION ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


// --*$*__*$*-- 💫🍎 START INFORMATIONS PRATIQUES ROUTES 💫🍎--*$*__*$*-- //
    // DOSSIERS
    Route::get('/get_list_somettre_dossier', [InfosPratiquesController::class, 'index_somettre_dossier']);
    Route::post('/add_new_somettre_dossier', [InfosPratiquesController::class, 'store_somettre_dossier']);
    Route::post('/update_current_somettre_dossier/{slg}', [InfosPratiquesController::class, 'update_somettre_dossier']);
    Route::get('/delete_current_somettre_dossier/{slg}', [InfosPratiquesController::class, 'delete_somettre_dossier']);

    // FAQ
    Route::get('/get_list_faqs', [InfosPratiquesController::class, 'index_faq']);
    Route::post('/add_new_faq', [InfosPratiquesController::class, 'store_faq']);
    Route::post('/update_current_faq/{slg}', [InfosPratiquesController::class, 'update_faq']);
    Route::get('/delete_current_faq/{slg}', [InfosPratiquesController::class, 'delete_faq']);

    // CALCULATOR FRAIS
    Route::get('/get_list_calculator_frais', [InfosPratiquesController::class, 'index_calculator_frais']);
    Route::post('/add_new_calculator_frais', [InfosPratiquesController::class, 'store_calculator_frais']);
    Route::post('/update_current_calculator_frais/{slg}', [InfosPratiquesController::class, 'update_calculator_frais']);
    Route::get('/delete_current_calculator_frais/{slg}', [InfosPratiquesController::class, 'delete_calculator_frais']);

    // COMMENT DEVENIR
    Route::get('/get_list_comment_devenir', [InfosPratiquesController::class, 'index_comment_devenir']);
    Route::post('/add_new_comment_devenir', [InfosPratiquesController::class, 'store_comment_devenir']);
    Route::post('/update_current_comment_devenir/{slg}', [InfosPratiquesController::class, 'update_comment_devenir']);
    Route::get('/delete_current_comment_devenir/{slg}', [InfosPratiquesController::class, 'delete_comment_devenir']);

    // SESSION SERVICES
    Route::get('/get_list_session_service', [SessionController::class, 'indexSservice']);
    Route::post('/add_new_session_service', [SessionController::class, 'storeSservice']);
    Route::post('/update_current_session_service/{slg}', [SessionController::class, 'updateSservice']);
    Route::get('/delete_current_session_service/{slg}', [SessionController::class, 'deleteSservice']);

    // ILLUSTRATION
    Route::get('/get_list_illustration_organisation', [OrganisationBannerController::class, 'index']);
    Route::post('/store_current_illustration_organisation', [OrganisationBannerController::class, 'store']);
    Route::post('/update_current_illustration_organisation/{slg}', [OrganisationBannerController::class, 'update']);
    Route::get('/delete_current_illustration_organisation/{slg}', [OrganisationBannerController::class, 'delete']);

    // SESSION EVENTS
    Route::get('/get_list_session_event', [SessionController::class, 'indexSevent']);
    Route::post('/add_new_session_event', [SessionController::class, 'storeSevent']);
    Route::post('/update_current_session_event/{slg}', [SessionController::class, 'updateSevent']);
    Route::get('/delete_current_session_event/{slg}', [SessionController::class, 'deleteSevent']);

    // SESSION TEAMS
    Route::get('/get_list_session_teams', [SessionController::class, 'indexSteams']);
    Route::post('/add_new_session_teams', [SessionController::class, 'storeSteams']);
    Route::post('/update_current_session_teams/{slg}', [SessionController::class, 'updateSteams']);
    Route::get('/delete_current_session_teams/{slg}', [SessionController::class, 'deleteSteams']);

    // SESSION PARTNERS
    Route::get('/get_list_session_partners', [SessionController::class, 'indexSpartners']);
    Route::post('/add_new_session_partners', [SessionController::class, 'storeSpartners']);
    Route::post('/update_current_session_partners/{slg}', [SessionController::class, 'updateSpartners']);
    Route::get('/delete_current_session_partners/{slg}', [SessionController::class, 'deleteSpartners']);

    // SESSION DELEGATIONS
    Route::get('/get_list_session_delegation', [SessionController::class, 'indexSdelegation']);
    Route::post('/add_new_session_delegation', [SessionController::class, 'storeSdelegation']);
    Route::post('/update_current_session_delegation/{slg}', [SessionController::class, 'updateSdelegation']);
    Route::get('/delete_current_session_delegation/{slg}', [SessionController::class, 'deleteSdelegation']);

    // SESSION PUBLICATIONS
    Route::get('/get_list_session_publication', [SessionController::class, 'indexSpublication']);
    Route::post('/add_new_session_publication', [SessionController::class, 'storeSpublication']);
    Route::post('/update_current_session_publication/{slg}', [SessionController::class, 'updateSpublication']);
    Route::get('/delete_current_session_publication/{slg}', [SessionController::class, 'deleteSpublication']);

    // SESSION NAVBAR MENU
    Route::get('/get_list_session_navbar_menu', [SessionController::class, 'indexSNavbarMenu']);
    Route::post('/add_new_session_navbar_menu', [SessionController::class, 'storeSNavbarMenu']);
    Route::post('/update_current_session_navbar_menu/{slg}', [SessionController::class, 'updateSNavbarMenu']);
    Route::get('/delete_current_session_navbar_menu/{slg}', [SessionController::class, 'deleteSNavbarMenu']);
    Route::put('/change_current_session_navbar_menu_order/{slg}', [SessionController::class, 'change_session_navbar_menu_item_order']);

    // SESSION NAVBAR SUBMENU
    Route::get('/get_list_session_sub_navbar_menu', [SessionController::class, 'indexSNavbarSubMenu']);
    Route::post('/add_new_session_sub_navbar_menu', [SessionController::class, 'storeSNavbarSubMenu']);
    Route::post('/update_current_session_sub_navbar_menu/{slg}', [SessionController::class, 'updateSNavbarSubMenu']);
    Route::get('/delete_current_session_sub_navbar_menu/{slg}', [SessionController::class, 'deleteSNavbarSubMenu']);
    Route::put('/change_current_session_sub_navbar_menu_order/{slg}', [SessionController::class, 'change_session_sub_navbar_item_order']);

    // SESSION FOOTER MENU
    Route::get('/get_list_session_footer_menu', [SessionController::class, 'indexSFooterMenu']);
    Route::post('/add_new_session_footer_menu', [SessionController::class, 'storeSFooterMenu']);
    Route::post('/update_current_session_footer_menu/{slg}', [SessionController::class, 'updateSFooterMenu']);
    Route::get('/delete_current_session_footer_menu/{slg}', [SessionController::class, 'deleteSFooterMenu']);
    Route::put('/change_current_session_footer_menu_order/{slg}', [SessionController::class, 'change_session_footer_menu_item_order']);

    // FAQ KEYWORDS
    Route::get('/get_list_faq_keyword', [FaqKeywordController::class, 'index']);
    Route::post('/add_new_faq_keyword', [FaqKeywordController::class, 'store']);
    Route::post('/update_current_faq_keyword/{slg}', [FaqKeywordController::class, 'update']);
    Route::get('/delete_current_faq_keyword/{slg}', [FaqKeywordController::class, 'delete']);
    Route::put('/change_current_faq_keyword_order/{slg}', [FaqKeywordController::class, 'change_item_order']);

    // OBJECT CONTACT
    Route::get('/get_list_contact_object', [ObjectContactController::class, 'index']);
    Route::post('/add_new_contact_object', [ObjectContactController::class, 'store']);
    Route::post('/update_current_contact_object/{slg}', [ObjectContactController::class, 'update']);
    Route::get('/delete_current_contact_object/{slg}', [ObjectContactController::class, 'delete']);
    Route::put('/change_current_contact_object_order/{slg}', [ObjectContactController::class, 'change_item_order']);

    // SESSION FOOTER SUBMENU
    Route::get('/get_list_session_footer_sub_menu', [SessionController::class, 'indexSFooterSubMenu']);
    Route::post('/add_new_session_footer_sub_menu', [SessionController::class, 'storeSFooterSubMenu']);
    Route::post('/update_current_session_footer_sub_menu/{slg}', [SessionController::class, 'updateSFooterSubMenu']);
    Route::get('/delete_current_session_footer_sub_menu/{slg}', [SessionController::class, 'deleteSFooterSubMenu']);
    Route::put('/change_current_session_footer_sub_menu_order/{slg}', [SessionController::class, 'change_session_footer_sub_menu_item_order']);

    // DOCUMENT JOINED
    Route::get('/get_list_document_join_by_code_ref/{code_ref}', [InfosPratiquesController::class, 'document_join_by_code_ref']);
    Route::get('/get_list_document_joins', [InfosPratiquesController::class, 'index_document_join']);
    Route::post('/add_new_document_join', [InfosPratiquesController::class, 'store_document_join']);
    Route::post('/update_current_document_join/{slg}', [InfosPratiquesController::class, 'update_document_join']);
    Route::get('/delete_current_document_join/{slg}', [InfosPratiquesController::class, 'delete_document_join']);
// 💫🍎 END INFORMATIONS PRATIQUES ROUTES 💫🍎--*$*__*$*-- --*$*__*$*-- //


});
//💫🍎 --*$*__*$*-- 💫🍎 BACKEND 💫🍎--*$*__*$*--💫🍎 //
//💫🍎--*$*__*$*--💫🍎 END 💫🍎 //
