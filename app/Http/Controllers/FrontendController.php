<?php

namespace App\Http\Controllers;

use App\Models\CompetenceModel;
use App\Models\CountrieModel;
use App\Models\DelegationModel;
use App\Models\faq;
use App\Models\CvModel;
use App\Models\EventModel;
use App\Models\FonctionModel;
use App\Models\LanguageModel;
use App\Models\MotDuPresidentModel;
use App\Models\ProfessionModel;
use App\Models\TeamsModel;
use App\Models\BannerModel;
use App\Models\DocumentJoin;
use App\Models\messageModel;
use Illuminate\Http\Request;
use App\Models\AgendasModels;
use App\Models\PartnersModel;
use App\Models\ServicesModel;
use App\Models\SlideUneModel;
use App\Models\MissionsModels;
use App\Services\MessageService;
use App\Models\HistoriquesModels;
use App\Models\LiensUtilesModels;
use App\Models\PresentationModel;
use App\Models\TestimonialsModel;
use App\Models\PublicarionsModels;
use App\Models\SoumettreDocsModel;
use App\Models\TypesServicesModel;
use Illuminate\Support\Facades\DB;
use App\Models\CommentDevenirModel;
use App\Models\OrganisationsModels;
use App\Models\ReseauxSociauxModel;
use App\Models\TermsAndPolicyModel;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use App\Models\CalculatorFraisModel;
use App\Models\TypePublicationModel;
use App\Models\ObjectContactModel;
use App\Models\FaqKeywordModel;

use App\Models\SessionEventModel;
use App\Models\SessionPartnersModel;
use App\Models\SessionTeamsModel;
use App\Models\SessionServiceModel;
use App\Models\SessionPublicationModel;

use App\Models\SessionFooterMenuModel;
use App\Models\SessionFooterSubMenuModel;
use App\Models\SessionNavMenuModel;
use App\Models\SessionSubNavMenuModel;

use App\Models\OrganisationBannerModel;
use App\Models\FolderUsModel;
use App\Models\SessionDelegationModel;
use App\Models\StatisticsModel;
use App\Models\TypeEventModel;
use Illuminate\Support\Facades\URL;


class FrontendController extends Controller
{



// ======= START =========== ======= //
// ======= =========== CONTACT US DETAILS =========== ======= //
    public function store__contact__us(Request $request){
        try {

            if(empty($request->fullname)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('nom complet')
                    ]
                );
            endif;
            if(empty($request->email)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('email')
                    ]
                );
            endif;
            if(empty($request->tel)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('numéro de téléphone')
                    ]
                );
            endif;
            if(empty($request->profession)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('proféssion')
                    ]
                );
            endif;
            if(empty($request->object)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('objet')
                    ]
                );
            endif;
            if(empty($request->requerent)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('réquerant')
                    ]
                );
            endif;
            if(empty($request->message)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('message')
                    ]
                );
            endif;

            $add = new messageModel();
            $add->author_id = 0;
            $add->fullname = $request->fullname;
            $add->email = $request->email;
            $add->tel = $request->tel;
            $add->type_procedure = $request->type_procedure;
            $add->profession = $request->profession;
            $add->object = $request->object;
            $add->requerent = $request->requerent;
            $add->message = $request->message;
            if(!empty($request->file) && $request->type_media != "youtube"):
                if($request->hasFile('file')):
                    $file = $request->file('file');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'file_'.time().'.'.$extension;
                    if($filename):
                        $pulic_path = 'media/docs/';
                        $file->move(public_path($pulic_path) , $filename);
                    else:
                        return "error";
                    endif;
                    $path = $pulic_path;
                    $image_url = URL::to('').'/'.$path.$filename;
                    $add->file = $image_url;
                endif;
            else:
                $add->file = $request->file;
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
    //
    public function follow_my_folder(Request $request){

    }
// ======= =========== CONTACT US DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== SESSIONS DETAILS =========== ======= //
    // list
    public function get_frontent_session_list(){
        try {

            $list_sessions_footer_menu = SessionFooterMenuModel::OrderBy('item_order', 'asc')->groupBy('id', 'item_order')->get();
            $list_sessions_footer_sub_menu = SessionFooterSubMenuModel::OrderBy('session_footer_sub_menu_models.item_order', 'asc')
            ->groupBy('session_footer_sub_menu_models.id', 'session_footer_sub_menu_models.item_order')
            ->join('session_footer_menu_models', 'session_footer_sub_menu_models.nav_footer_item_id', 'session_footer_menu_models.id')
            ->select('session_footer_menu_models.*', 'session_footer_sub_menu_models.*')
            ->get();
            $list_sessions_navbar_menu = SessionNavMenuModel::OrderBy('item_order', 'asc')->groupBy('id', 'item_order')->get();
            $list_sessions_navbar_sub_menu = SessionSubNavMenuModel::OrderBy('item_order', 'asc')->groupBy('id', 'item_order')->get();

            $list_session_navbar_menu = SessionNavMenuModel::with('subMenus')
            ->orderBy('item_order', 'asc')->groupBy('id', 'item_order')
            ->get()->map(function ($menu) {
                    return [
                        'id' => $menu->id,
                        'nav_item' => $menu->nav_item,
                        'title' => $menu->title,
                        'status_nav_list' => $menu->status_nav_list,
                        'route' => $menu->route == null?'':json_decode(str_replace("'", '"', $menu->route)),
                        'nav_list' => $menu->subMenus->map(function ($subMenu) {
                            return [
                                'id' => $subMenu->id,
                                'nav_list_item' => $subMenu->nav_list_item,
                                'nav_list_item_code' => $subMenu->nav_list_item_code,
                                'title' => $subMenu->title,
                                'route' => json_decode(str_replace("'", '"', $subMenu->route), true)
                            ];
                        })->toArray()
                ];
            });

            $list_session_footer_menu = SessionFooterMenuModel::with('subMenus')
            ->orderBy('item_order', 'asc')->groupBy('id', 'item_order')
            ->get()->map(function ($menu) {
                    return [
                        'id' => $menu->id,
                        'nav_footer_item' => $menu->nav_footer_item,
                        'perimetre' => $menu->perimetre,
                        'footer_sub_menu' => $menu->subMenus->map(function ($subMenu) {
                            return [
                                'id' => $subMenu->id,
                                'item_order' => $subMenu->item_order,
                                'nav_list_footer_item_icon' => $subMenu->nav_list_footer_item_icon,
                                'nav_list_footer_item' => $subMenu->nav_list_footer_item,
                                'nav_list_footer_item_type_content' => $subMenu->nav_list_footer_item_type_content,
                                'nav_list_footer_item_content' => json_decode($subMenu->nav_list_footer_item_content),
                                'slug' => $subMenu->slug,
                                'created_at' => $subMenu->created_at,
                                'updated_at' => $subMenu->updated_at,
                            ];
                        })
                ];
            });

            // $list_session_footer_menu = SessionFooterMenuModel::OrderBy('item_order', 'asc')->groupBy('id', 'item_order')->get();

            if(
                $list_session_navbar_menu ||
                $list_session_footer_menu
            ){
                return response()->json(
                    [
                        'list_sessions_footer_menu' => $list_sessions_footer_menu,
                        'list_sessions_navbar_menu' => $list_sessions_navbar_menu,
                        'list_sessions_navbar_sub_menu' => $list_sessions_navbar_sub_menu,
                        'list_sessions_footer_sub_menu' => $list_sessions_footer_sub_menu,
                        'list_session_navbar_full_menu' => $list_session_navbar_menu,
                        'list_session_footer_full_menu' => $list_session_footer_menu,
                    ]
                );
            }else{
                return response()->json(
                    [
                        'list_sessions_footer_menu' => [],
                        'list_sessions_navbar_menu' => [],
                        'list_sessions_navbar_sub_menu' => [],
                        'list_sessions_footer_sub_menu' => [],
                        'list_session_navbar_full_menu' => [],
                        'list_session_footer_full_menu' => [],
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
// ======= =========== SESSIONS DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== BANNERS DETAILS =========== ======= //
    // list
    public function get_list_banners(){
        try {
            $list = BannerModel::OrderByDesc('id')->first();
            if($list != null){return $list;}
            else{return $list = null;}
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
// ======= =========== BANNERS DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== ARCHIVES DETAILS =========== ======= //
    // list
    public function get_archives(){
        try {
            $list = DB::table('event_models')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(id) as total')
            )
            ->groupBy('year', 'month')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();
            if($list != null){return $list;}
            else{return $list = [];}
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
    public function get_details_archives($month, $year){
        try {
            $list = DB::table('event_models')
            ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'event_models.*')
            ->whereMonth('event_models.created_at', $month)
            ->whereYear('event_models.created_at', $year)
            ->orderByDesc('event_models.created_at')
            ->get();
            if($list != null){return $list;}
            else{return $list = [];}
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
// ======= =========== BANNERS DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== LIENS UTILES DETAILS =========== ======= //
    // list
    public function get_terms_and_policys(){
        try {
            $list = TermsAndPolicyModel::OrderByDesc('id')->first();
            if($list != null){return $list;}
            else{return $list = [];}
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
// ======= =========== LIENS UTILES DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== RESEAU SOCIAL DETAILS =========== ======= //
    // list
    public function get_reseau_social(){
        try {
            $list = ReseauxSociauxModel::OrderByDesc('id')->get();
            if($list != null){return $list;}
            else{return $list = [];}
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
// ======= =========== RESEAU SOCIAL DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== LIENS UTILES DETAILS =========== ======= //
    // list
    public function get_lien_utile(){
        try {
            $content = LiensUtilesModels::OrderByDesc('id')->first();
            $menu = SessionSubNavMenuModel::Join('session_nav_menu_models', 'session_sub_nav_menu_models.nav_item_id', 'session_nav_menu_models.id')
            ->select('session_nav_menu_models.*', 'session_sub_nav_menu_models.*')
            ->get()
            ->map(function ($menu) {
                // Transformer en minuscules
                $menu->nav_list_item = strtolower($menu->nav_list_item);
                return $menu;
            })->first(function ($menu) {
                // Appliquez la condition pour obtenir le premier élément correspondant
                return $menu->nav_list_item_code == 'SUBMENU-014';
            });

            if ($menu) {
                // Si un élément est trouvé, formatez-le en tableau
                $menu = [
                    'id' => $menu->id,
                    'nav_list_item_code' => $menu->nav_list_item_code,
                    'nav_list_item' => $menu->nav_list_item,
                    'nav_item_code' => $menu->nav_item_code,
                    'route' => $menu->route,
                    'slug' => $menu->slug,
                    'created_at' => $menu->created_at,
                    'updated_at' => $menu->updated_at,
                ];
            }
            if($content != null){
                return response()->json(
                    [
                        'content' => $content,
                        'menu' => $menu
                    ]
                );
            }
            else{return $list = [];}
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
// ======= =========== LIENS UTILES DETAILS =========== ======= //
// ======= END =========== ======= //

// ======= START =========== ======= //
// ======= =========== SESSION DETAILS =========== ======= //
    // Session Service
    public function get_session_service(){
        try {
            $item = SessionServiceModel::OrderByDesc('id')->first();
            if($item != null){return $item;}
            else{return $item = [];}
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
    // Session Event
    public function get_session_event(){
        try {
            $item = SessionEventModel::OrderByDesc('id')->first();
            if($item != null){return $item;}
            else{return $item = [];}
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
    // Session Teams
    public function get_session_teams(){
        try {
            $item = SessionTeamsModel::OrderByDesc('id')->first();
            if($item != null){return $item;}
            else{return $item = [];}
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
    // Session Partners
    public function get_session_partners(){
        try {
            $item = SessionPartnersModel::OrderByDesc('id')->first();
            if($item != null){return $item;}
            else{return $item = [];}
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
    // Session Delegation
    public function get_session_delegations(){
        try {
            $item = SessionDelegationModel::OrderByDesc('id')->first();
            if($item != null){return $item;}
            else{return $item = [];}
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
// ======= =========== SESSION DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== EVENTS DETAILS =========== ======= //
    // list
    public function get__list__events(){
        try {
            $events = EventModel::OrderBy('event_models.event_date', 'desc')
            ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'event_models.*')
            ->groupBy('event_models.id', 'event_models.item_order')
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
    public function current__event__details($slug){
        try {
            if(isset($slug)):
                // return $slug;
                $data_event = EventModel::Where('event_models.slug', '=', $slug)
                ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
                ->join('admin_account_models', 'event_models.author_id', '=', 'admin_account_models.id')
                ->select('admin_account_models.*', 'admin_account_models.id as user_id','type_event_models.type_event', 'event_models.*')
                ->first();

                if($data_event){
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
            $statistique_person = TeamsModel::all();

            $data_event = EventModel::OrderBy('event_models.event_date', 'desc')
            ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'event_models.*')
            ->groupBy('event_models.id', 'event_models.item_order')
            ->get();

            $data_banner = BannerModel::OrderByDesc('id')->get();


            $data_partners = PartnersModel::OrderBy('item_order', 'asc')->groupBy('id', 'item_order')->get();
            $data_testimonial = TestimonialsModel::OrderByDesc('id')->get();

            $data_presentation = PresentationModel::OrderByDesc('presentation_models.id')
            ->join('type_event_models', 'presentation_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'presentation_models.*')
            ->first();

            $session_service = SessionServiceModel::OrderByDesc('id')->first();
            $session_event = SessionEventModel::OrderByDesc('id')->first();
            $session_teams = SessionTeamsModel::OrderBy('id', 'asc')->first();
            $session_admin_teams = SessionTeamsModel::OrderByDesc('id')->first();
            $session_partners = SessionPartnersModel::OrderByDesc('id')->first();
            $session_publication = SessionPublicationModel::OrderByDesc('id')->first();


            $list_events = EventModel::OrderBy('event_models.event_date', 'desc')
            ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'event_models.*')
            ->groupBy('event_models.id', 'event_models.item_order')
            ->get();
            $list_type_services =TypesServicesModel::groupBy('id', 'item_order')
            ->orderBy('item_order', 'desc')
            ->get();

            $popup_banner = BannerModel::OrderByDesc('id')->first();
            $last_vs_stats = StatisticsModel::latest()->first();

            $data_secretariat_person= TeamsModel::OrderByDesc('teams_models.id')
            ->join('organisations_models', 'teams_models.organisation', '=',  'organisations_models.code_org')
            ->select('organisations_models.*', 'teams_models.*')
            //
            ->where(function ($query) {
                $query->whereRaw('LOWER(organisations_models.title) = ?', ['secrétariat général'])
                ->orWhereRaw('LOWER(organisations_models.title) = ?', ['secretariat general']);
            })
            ->where('teams_models.category_person', '=', 'Organisation')
            //
            ->get();

            $data_administration_persons = TeamsModel::orderByDesc('teams_models.id')
            ->join('organisations_models', 'teams_models.organisation', '=', 'organisations_models.code_org')
            ->select('organisations_models.*', 'teams_models.*')
            ->where('organisations_models.title', 'like', '%'.'administration'.'%')
            // ->where('teams_models.category_person', '=', 'Organisation')
            ->get();

            if(
                $data_event != null ||
                $data_banner != null ||
                $data_secretariat_person != null ||
                $data_partners != null ||
                $data_testimonial != null ||
                $data_une != null ||
                $data_presentation != null
            ){
                return response()->json(
                    [
                        'session_service' => $session_service,
                        'session_event' => $session_event,
                        'session_teams' => $session_teams,
                        'session_admin_teams' => $session_admin_teams,
                        'session_partners' => $session_partners,
                        'session_publication' => $session_publication,
                        'data_une' => $data_une,
                        'statistique_person' => $statistique_person,
                        'data_event' => $data_event,
                        'data_banner' => $data_banner,
                        'data_personal' => [
                            "list_welcome_administration_persons" => $data_administration_persons,
                            "list_organisation_persons" => TeamsModel::OrderByDesc('id')->where('category_person', '=', 'Organisation')->get(),
                            "list_repertoire_persons" => TeamsModel::OrderByDesc('id')->where('category_person', '=', 'Répertoire')->get(),
                            "list_delegation_persons" => TeamsModel::OrderByDesc('id')->where('category_person', '=', 'Délégation')->get(),
                            "list_welcome_secretariat_persons" => $data_secretariat_person,
                        ],
                        'data_partners' => $data_partners,
                        'data_testimonial' => $data_testimonial,
                        'data_presentation' => $data_presentation,
                        'list_events' => $list_events,
                        'list_type_services' => $list_type_services,
                        'popup_banner' => $popup_banner,
                        'last_vs_stats' => $last_vs_stats,
                    ]
                );
            }
            else{
                return response()->json(
                    [
                        'statistique_person' => 0,
                        'data_event' => [],
                        'data_banner' => [],
                        'data_personal' => [],
                        'data_partners' => [],
                        'data_testimonial' => [],
                        'list_events' => [],
                        'list_services' => [],
                        'popup_banner' => [],
                        'last_vs_stats' => null,
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
            $last = OrganisationsModels::Join('admin_account_models', 'organisations_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'organisations_models.*')
            ->first();

            // // Transformation du résultat pour obtenir un format clé-valeur dans la réponse JSON
            // $formattedList = $list->mapWithKeys(function ($items, $name) {
            //     return [$name => $items->values()];
            // });

            $item = OrganisationBannerModel::OrderByDesc('id')->first();

            if($item != null)
            {
                return response()->json(
                    [
                        'item' => $item,
                        'last' => $last
                    ]
                );
            }else{
                return response()->json(
                    [
                        'item' => null,
                        'last' => $last
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
    public function content_list_organisation(){
        try {
            $list = OrganisationsModels::Join('admin_account_models', 'organisations_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'organisations_models.*')
            ->get();

            if($list != null){return $list;}
            else{return $list = null;}
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
    public function details_current_organisation($code_org){
        try {
            if(isset($code_org)):
                $data = TeamsModel::Where('teams_models.organisation', '=', $code_org)
                ->where('teams_models.category_person', '=', 'Organisation')
                ->join('organisations_models', 'teams_models.organisation', '=', 'organisations_models.code_org')
                ->join('admin_account_models', 'teams_models.author_id', '=', 'admin_account_models.id')
                ->select(
                    'organisations_models.*',
                    'organisations_models.id as organisation_id',
                    'admin_account_models.*',
                    'admin_account_models.id as user_id',
                    'teams_models.*'
                )->get();

                if($data){
                    return $data;
                }else{
                    return response()->json(
                        [
                            'code' => 400,
                            'data' => [],
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
    public function get_mi_portfolio_content($slug){
        try {
            if(isset($slug)):
                $data = TeamsModel::Where('teams_models.slug', '=', $slug)
                ->join('organisations_models', 'teams_models.organisation', '=', 'organisations_models.code_org')
                ->join('admin_account_models', 'teams_models.author_id', '=', 'admin_account_models.id')
                ->select(
                    'organisations_models.*',
                    'organisations_models.id as organisation_id',
                    'admin_account_models.*',
                    'admin_account_models.id as user_id',
                    'teams_models.*'
                )->first();

                $cv_data = CvModel::Join('admin_account_models', 'cv_models.author_id', '=', 'admin_account_models.id')
                ->join('teams_models', 'cv_models.matricule', '=', 'teams_models.matricule')
                ->select(
                    'teams_models.*',
                    'teams_models.id as teams_id',
                    'admin_account_models.*',
                    'admin_account_models.id as user_id',
                    'cv_models.*'
                )
                ->where('cv_models.matricule', $data->matricule)
                ->orderBy('cv_models.id', 'asc')
                ->get();

                if($data){
                    return response()->json(
                        [
                            'data' => $data,
                            'cv_data' => $cv_data
                        ]
                    );
                }else{
                    return response()->json(
                        [
                            'code' => 400,
                            'data' => [],
                            'cv_data' => [],
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
// ======= =========== ORGANISATION DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== MISSIONS DETAILS =========== ======= //
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
// ======= =========== MISSIONS DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== MOT DU PRESIDENT DETAILS =========== ======= //
    public function content_mot_du_president(){
        try {
            $last_item = MotDuPresidentModel::Join('admin_account_models', 'mot_du_president_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'mot_du_president_models.*')
            ->orderByDesc('mot_du_president_models.updated_at')
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
// ======= =========== MOT DU PRESIDENT DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== DELEGATION DETAILS =========== ======= //
    public function content_delegation(){
        try {
            $last_item = DelegationModel::OrderBy('delegation_models.item_order', 'asc')
            ->groupBy('delegation_models.id', 'delegation_models.item_order')
            ->join('teams_models', 'delegation_models.representant_id', 'teams_models.id')
            ->select('teams_models.*', 'teams_models.id as team_id', 'teams_models.slug as person_slug', 'delegation_models.*')
            ->get();
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
    public function content_current_delegation($slug){
        try {
            $last_item = DelegationModel::OrderBy('delegation_models.item_order', 'asc')
            ->groupBy('delegation_models.id', 'delegation_models.item_order')
            ->join('teams_models', 'delegation_models.representant_id', 'teams_models.id')
            ->select('teams_models.*', 'teams_models.id as team_id', 'teams_models.slug as person_slug', 'delegation_models.*')
            ->where('delegation_models.slug', $slug)
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
// ======= =========== DELEGATION DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== AGENDA CONTENT =========== ======= //
    public function content__agenda(){
        try {
            $list = AgendasModels::Join('admin_account_models', 'agendas_models.author_id', '=', 'admin_account_models.id')
            ->join('type_event_models', 'agendas_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'admin_account_models.*', 'admin_account_models.id as user_id', 'agendas_models.*')->get();
            if($list != null){return $list;}
            else{return $list = null;}
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
    public function get__type_events__from__content__agenda(){
        try {
            $list = TypeEventModel::OrderBy('item_order', 'asc')->groupBy('id', 'item_order')->get();
            if($list != null){return $list;}
            else{return $list = null;}
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
// ======= =========== AGENDA CONTENT =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== INFORMATIONS PRATIQUES CONTENT =========== ======= //
    public function content__info_pratique(){
        try {
            // $list = InfosPratiquesModels::Join('admin_account_models', 'agendas_models.author_id', '=', 'admin_account_models.id')
            // ->join('type_event_models', 'agendas_models.type_event_id', '=', 'type_event_models.id')
            // ->select('type_event_models.type_event', 'admin_account_models.*', 'admin_account_models.id as user_id', 'agendas_models.*')->get();
            // if($list != null){return $list;}
            // else{return $list = null;}
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
// FAQ
    public function store_faq(Request $request){
        try {

            if(empty($request->ask)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('question')
                    ]
                );
            endif;

            $list = faq::Where('ask', 'like', '%'. $request->ask .'%')
            ->OrWhere('keyword', 'like', '%'. $request->ask .'%')
            ->OrWhere('answere', 'like', '%'. $request->ask .'%')
            ->get();

            if($list != null){
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'list' => $list,
                        'message' => MessageService::code100()
                    ]
                );
            }else{
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'list' => [],
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
    public function get_faq(){
        try {
            $list = faq::OrderByDesc('id')->get();
            if($list != null ){
                return $list;
            }else{return [];}
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
// CALCULATOR FRAIS
    public function get_calculators_frais(){
        try {
            $list = CalculatorFraisModel::all();
            if($list != null ){
                return $list;
            }else{return [];}
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

// MEMBERS
    public function get_list_members(){
        try {

            $list_organisation_persons = TeamsModel::OrderByDesc('id')->where('category_person', '=', 'Organisation')->get();
            $list_repertoire_persons = TeamsModel::OrderByDesc('id')->where('category_person', '=', 'Répertoire')->get();
            $list_delegation_persons = TeamsModel::OrderByDesc('id')->where('category_person', '=', 'Délégation')->get();

            if(
                $list_delegation_persons != null ||
                $list_repertoire_persons != null ||
                $list_organisation_persons != null
            ){
                return response()->json(
                    [
                        'list_organisation_persons' => $list_organisation_persons,
                        'list_repertoire_persons' => $list_repertoire_persons,
                        'list_delegation_persons' => $list_delegation_persons,
                    ]
                );
            }else{return [];}
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

// CONTACT OBJECT
    public function get_contact_object(){
        try {
            $list = ObjectContactModel::all();
            if($list != null ){
                return $list;
            }else{return [];}
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

// FAQ KEYWORD
    public function get_faq_keyword(){
        try {
            $list = FaqKeywordModel::all();
            if($list != null ){
                return $list;
            }else{return [];}
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


// GET SEARCH GLOBAL COLLECTIONS
    public function get_frontend_search_all_collection(){
        try {
            $list_profession = ProfessionModel::all();
            $list_country = CountrieModel::all();
            $list_fonction = FonctionModel::all();
            $list_langue = LanguageModel::all();
            $list_competence = CompetenceModel::all();
            if(
                $list_profession != null ||
                $list_country != null ||
                $list_fonction != null ||
                $list_langue != null ||
                $list_competence != null
            ){
                return response()->json(
                    [
                        'list_competence' => $list_competence,
                        'list_country' => $list_country,
                        'list_fonction' => $list_fonction,
                        'list_langue' => $list_langue,
                        'list_profession' => $list_profession
                    ]
                );
            }else{
                return response()->json(
                    [
                        'list_competence' => [],
                        'list_country' => [],
                        'list_fonction' => [],
                        'list_langue' => [],
                        'list_profession' => []
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


// COUNTRIES
    public function get_list_countries(){
        try {
            $list = CountrieModel::all();
            if($list != null ){
                return $list;
            }else{return [];}
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


// PROFESSIONS
    public function get_list_professions(){
        try {
            $list = ProfessionModel::all();
            if($list != null ){
                return $list;
            }else{return [];}
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


// FONCTIONS
    public function get_list_fonctions(){
        try {
            $list = FonctionModel::all();
            if($list != null ){
                return $list;
            }else{return [];}
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


// SOUMETTRE DOCS
    public function get_soumettre_docs(){
        try {
            $list = SoumettreDocsModel::all();
            if($list != null ){
                return $list;
            }else{return [];}
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
    public function fetch_soumettre_docs_by__code__ref(Request $request){
        try {
            if(isset($request->folder_code)){

                $folder = FolderUsModel::OrderByDesc('id')
                ->join('type_procedure_models', 'folder_us_models.type_procedure_id', 'type_procedure_models.id')
                ->select('type_procedure_models.type_procedure', 'folder_us_models.*')
                ->with('analyse')
                ->where('ref_folder', '=', $request->folder_code)
                ->first();

                if ($folder) {
                    $folder = [
                        'id' => $folder->id,
                        'author_id' => $folder->author_id,
                        'type_procedure_id' => $folder->type_procedure_id,
                        'type_procedure' => $folder->type_procedure,
                        'dossier_follower' => $folder->dossier_follower,
                        'ref_folder' => $folder->ref_folder,
                        'fullname' => $folder->fullname,
                        'email' => $folder->email,
                        'tel' => $folder->tel,
                        'professions' => $folder->professions,
                        'description' => $folder->description,
                        'file' => $folder->file,
                        'already_step' => $folder->already_step,
                        'status_folder_analyse' => $folder->status_folder_analyse,
                        'status_finished' => $folder->status_finished,
                        'status_answere' => $folder->status_answere,
                        'created_at' => $folder->created_at,
                        'updated_at' => $folder->updated_at,
                        'slug' => $folder->slug,
                        'folder_analyse_list' => $folder->analyse->map(function ($analyse) {
                            return [
                                'id' => $analyse->id,
                                'author_id' => $analyse->author_id,
                                'folder_us_id' => $analyse->folder_us_id,
                                'object' => $analyse->object,
                                'comments' => $analyse->comments,
                                'current_step' => $analyse->current_step,
                                'next_step' => $analyse->next_step,
                                'next_step_date' => $analyse->next_step_date,
                                'status_analyse' => $analyse->status_analyse,
                                'created_at' => $analyse->created_at,
                                'updated_at' => $analyse->updated_at,
                            ];
                        })->toArray()
                    ];
                }

                if($folder != null){
                    return response()->json(
                        [
                            'code' => 100,
                            'status' => 'Succès',
                            'folder' => $folder
                        ]
                    );
                }else{
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code300()
                        ]
                    );
                }
            }else{
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code303()
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
// DEVENIR
    public function get_devenir(){
        try {
            $list = CommentDevenirModel::all();
            if($list != null ){
                return $list;
            }else{return [];}
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
// INFO PRATIQUES
    public function get__current__document__join($code_ref){
        try {
            if(isset($code_ref)):

                $list = DocumentJoin::Join('admin_account_models', 'document_joins.author_id', '=', 'admin_account_models.id')
                ->where('document_joins.code_ref_libelle', '=', $code_ref)
                ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'document_joins.*')->get();

                if($list != null ){
                    return $list;
                }else{return [];}
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

    public $originalText;
    public $type;
    public function get__current__type__content($type){
        try {
            if(isset($type)):
                // $this->originalText = str_replace('-', ' ', $type_content);
                $this->type = $type;

                $menu = SessionSubNavMenuModel::Join('session_nav_menu_models', 'session_sub_nav_menu_models.nav_item_id', 'session_nav_menu_models.id')
                ->select('session_nav_menu_models.*', 'session_sub_nav_menu_models.*')
                ->get()
                ->map(function ($menu) {
                    // Transformer en minuscules
                    $menu->nav_list_item = strtolower($menu->nav_list_item);
                    return $menu;
                })->first(function ($menu) {
                    // Appliquez la condition pour obtenir le premier élément correspondant
                    return $menu->nav_list_item_code == $this->type;
                });

                if ($menu) {
                    // Si un élément est trouvé, formatez-le en tableau
                    $menu = [
                        'id' => $menu->id,
                        'nav_list_item_code' => $menu->nav_list_item_code,
                        'nav_list_item' => $menu->nav_list_item,
                        'nav_item_code' => $menu->nav_item_code,
                        'route' => $menu->route,
                        'slug' => $menu->slug,
                        'created_at' => $menu->created_at,
                        'updated_at' => $menu->updated_at,
                    ];
                }

                if($menu != null ){
                    return $menu;
                }else{return null;}
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
// ======= =========== INFORMATIONS PRATIQUES CONTENT =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== PARTNERS DETAILS =========== ======= //
    public function content_partner(){
        try {
            $list_partners = PartnersModel::OrderBy('item_order', 'asc')->groupBy('id', 'item_order')->get();
            $list_organisation_persons = TeamsModel::OrderByDesc('id')->where('category_person', '=', 'Organisation')->get();
            $list_repertoire_persons = TeamsModel::OrderByDesc('id')->where('category_person', '=', 'Répertoire')->get();
            $list_delegation_persons = TeamsModel::OrderByDesc('id')->where('category_person', '=', 'Délégation')->get();

            if(
                $list_partners != null
            || $list_organisation_persons != null
            || $list_repertoire_persons != null
            || $list_delegation_persons != null
            ){
                return response()->json(
                    [
                        'list_organisation_persons' => $list_organisation_persons,
                        'list_repertoire_persons' => $list_repertoire_persons,
                        'list_delegation_persons' => $list_delegation_persons,
                        'list_partners' => $list_partners
                    ]
                );
            }
            else{
                return response()->json(
                    [
                        'list_persons' => [],
                        'list_partners' => []
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
// ======= =========== PARTNERS DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== PUBLICATIONS DETAILS =========== ======= //
    public function content_publication(){
        try {
            $list_type_publications = TypePublicationModel::all();

            $list_publications = TypePublicationModel::with('subMenus')
            ->groupBy('id')
            ->get()->map(function ($menu) {
                    return [
                        'id' => $menu->id,
                        'type_publication' => $menu->type_publication,
                        'type_publication_slug' => $menu->slug,
                        'item_content_list' => $menu->subMenus->map(function ($subMenu) {
                            return [
                                'id' => $subMenu->id,
                                'type_publication_id' => $subMenu->type_publication_id,
                                'libelle' => $subMenu->libelle,
                                'type_file' => $subMenu->type_file,
                                'url_file' => $subMenu->url_file,
                                'url' => $subMenu->url,
                                'slug' => $subMenu->slug,
                            ];
                        })->toArray()
                ];
            });
            if($list_publications != null){
                return response()->json(
                    [
                        'list_type_publications' => $list_type_publications,
                        'list_publications' => $list_publications
                    ]
                );
            }
            else{return [];}
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
            $list_types_services = TypesServicesModel::groupBy('id', 'item_order')
            ->orderBy('item_order', 'desc')
            ->get();

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
// ======= =========== SERVICES LIST =========== ======= //
    public function content_service($type_service_id){
        try {
            if(isset($type_service_id)):
                $title = TypesServicesModel::Where('id', $type_service_id)->value('type_service');
                $list = ServicesModel::Join('admin_account_models', 'services_models.author_id', '=', 'admin_account_models.id')
                ->where('services_models.type_service_id', '=', $type_service_id)
                ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'services_models.*')->get();
                if($list != null){
                    return response()->json(
                        [
                            'list' => $list,
                            'title' => $title,
                        ]
                    );
                }
                else{return $list = [];}
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
// ======= =========== SERVICES LIST =========== ======= //
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


// ======= START =========== ======= //
// ======= =========== OTHERS REQUEST =========== ======= //
    // list
    public function get__frontend__special__patner(){
        try {
            $favorite_partner = PartnersModel::where('is_favorited', 1)
            ->first();

            if($favorite_partner != null){
                return response()->json(
                    [
                        'special_partner' => $favorite_partner
                    ]
                );
            }
            else{return $favorite_partner = null;}
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
// ======= =========== OTHERS REQUEST =========== ======= //
// ======= END =========== ======= //


}
