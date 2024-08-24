<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\TeamsModel;
use App\Models\BannerModel;
use Illuminate\Http\Request;
use App\Models\PartnersModel;
use App\Models\SlideUneModel;
use App\Models\MissionsModels;
use App\Services\MessageService;
use App\Models\HistoriquesModels;
use App\Models\TestimonialsModel;
use App\Models\PublicarionsModels;
use App\Models\TypesServicesModel;
use App\Models\OrganisationsModels;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use App\Models\TypePublicationModel;

class FrontendController extends Controller
{
    //


// ======= START =========== ======= //
// ======= =========== EVENTS DETAILS =========== ======= //
    // list
    public function get__list__events(){
        try {
            $events = EventModel::OrderByDesc('event_models.id')
            ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'event_models.*')
            ->get();
            if($events != null){return $events;}
            else{return $events = [];}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    // details
    public function current__event__details($title){
        try {
            return $title;
            if(isset($title)):
                $data_event = EventModel::Where('event_models.event_title', '=', $title)
                ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
                ->join('admin_account_models', 'event_models.author_id', '=', 'admin_account_models.id')
                ->select('admin_account_models.*', 'admin_account_models.id as user_id','type_event_models.type_event', 'event_models.*')
                ->first();
                if(
                    $data_event != null
                ){
                    return $data_event;
                }else{
                    return response()->json(
                        [
                            'code' => 400,
                            'data_event' => null,
                            'status' => 'Erreur',
                            'message' => "Aucun article trouvé !",
                        ]
                    );
                }
            else:
                return response()->json(
                    [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ]
                );
            endif;
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== EVENTS DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== CURRENT EVENT DETAILS =========== ======= //
    public function get_frontent_data(){
        try {
            $data_une = SlideUneModel::all();
            $data_event = EventModel::OrderByDesc('event_models.id')
            ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'event_models.*')
            ->get();
            $data_banner = BannerModel::OrderByDesc('id')->get();
            $data_personal = TeamsModel::OrderByDesc('id')->get();
            $data_partners = PartnersModel::OrderByDesc('id')->get();
            $data_testimonial = TestimonialsModel::OrderByDesc('id')->get();
            if(
                $data_event != null ||
                $data_banner != null ||
                $data_personal != null ||
                $data_partners != null ||
                $data_testimonial != null ||
                $data_une != null
            ){
                return response()->json(
                    [
                        'data_une' => $data_une,
                        'data_event' => $data_event,
                        'data_banner' => $data_banner,
                        'data_personal' => $data_personal,
                        'data_partners' => $data_partners,
                        'data_testimonial' => $data_testimonial,
                    ]
                );
            }
            else{
                return response()->json(
                    [
                        'data_event' => [],
                        'data_banner' => [],
                        'data_personal' => [],
                        'data_partners' => [],
                        'data_testimonial' => [],
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== CURRENT EVENT DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== CURRENT EVENT DETAILS =========== ======= //

// ======= =========== CURRENT EVENT DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== HISTORIQUE DETAILS =========== ======= //
    public function content_historique(){
        try {
            $last_item = HistoriquesModels::Join('admin_account_models', 'historiques_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'historiques_models.*')
            ->orderByDesc('historiques_models.updated_at')
            ->first();
            if($last_item != null){return $last_item;}
            else{return $last_item = null;}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== HISTORIQUE DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== ORGANISATION DETAILS =========== ======= //
    public function content_organisation(){
        try {
            $last_item = OrganisationsModels::Join('admin_account_models', 'organisations_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'organisations_models.*')
            ->orderByDesc('organisations_models.updated_at')
            ->first();
            if($last_item != null){return $last_item;}
            else{return $last_item = null;}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== ORGANISATION DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== HISTORIQUE DETAILS =========== ======= //
    public function content_mission(){
        try {
            $last_item = MissionsModels::Join('admin_account_models', 'missions_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'missions_models.*')
            ->orderByDesc('missions_models.updated_at')
            ->first();
            if($last_item != null){return $last_item;}
            else{return $last_item = null;}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== HISTORIQUE DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== PARTNERS DETAILS =========== ======= //
    public function content_partner(){
        try {
            $list_partners = PartnersModel::OrderByDesc('id')->get();
            $list_persons = TeamsModel::OrderByDesc('id')->get();
            if($list_persons != null || $list_partners != null){
                return response()->json(
                    [
                        'list_persons' => $list_persons,
                        'list_partners' => $list_partners
                    ]
                );
            }
            else{return $last_item = null;}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== PARTNERS DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== PUBLICATIONS DETAILS =========== ======= //
    public function content_publication(){
        try {
            $list_publications = PublicarionsModels::Join('admin_account_models', 'publicarions_models.author_id', '=', 'admin_account_models.id')
            ->join('type_publication_models', 'publicarions_models.type_publication_id', '=', 'type_publication_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'type_publication_models.type_publication', 'publicarions_models.*')
            ->get();
            $list_type_publications = TypePublicationModel::all();
            if($list_type_publications != null || $list_publications != null){
                return response()->json(
                    [
                        'list_type_publications' => $list_type_publications,
                        'list_publications' => $list_publications
                    ]
                );
            }
            else{return $last_item = null;}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== PUBLICATIONS DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== TYPES SERVICES LIST =========== ======= //
    public function get__list__type__service(){
        try {
            $list_types_services = TypesServicesModel::all();
            if($list_types_services != null){return $list_types_services;}else{return $list_types_services = [];}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function get__current__type__service($code){
        try {
            if(isset($code)):
                $current__type__service = TypesServicesModel::Where('type_service_code', '=', $code)->first();
                if($current__type__service != null){
                    return $current__type__service;
                }else{
                    return null;
                }
            endif;
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== TYPES SERVICES LIST =========== ======= //
// ======= END =========== ======= //



// ======= START =========== ======= //
// ======= =========== COMMENTS DETAILS =========== ======= //
    public function store__comments(Request $request){
        // models no know
        // migration no know
        try {
            if(empty($request->type_event_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('type d\'évènement')
                    ]
                );
            endif;
            if(empty($request->title)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('titre de l\'article')
                    ]
                );
            endif;
            if(empty($request->description)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('description')
                    ]
                );
            endif;
            if(empty($request->event_img_0)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('illustration(image)')
                    ]
                );
            endif;
            if(empty($request->author)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('auteur')
                    ]
                );
            endif;

            $add = new EventModel();
            $add->author = $request->author;
            $add->type_event_id = $request->type_event_id;
            $add->event_description = $request->description;
            $add->event_title = $request->title;

            if(!empty($request->event_img_0)):
                $file = UploadFileService::uploadFileMultiple($request);
                if($file == "error"):
                    return response()->json(
                        [
                            'code' => 400,
                            'status' => 'Erreur',
                            'message' => MessageService::code400()
                        ]
                    );
                else:
                    $add->event_img = json_encode($file);
                endif;
            endif;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()){
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'message' => MessageService::code100()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== COMMENTS DETAILS =========== ======= //
// ======= END =========== ======= //
}
