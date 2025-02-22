<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Fruitcake\Cors\HandleCors;
use App\Services\MessageService;
use App\Models\TeamsModel;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class TeamsController extends Controller
{

    protected $middleware = [
        'auth:api', // Reference the middleware group
    ];

    public function __construct()
    {
        $this->middleware;
    }

    public function index(){
        try {
            $list = TeamsModel::OrderByDesc('teams_models.id')
            ->join('admin_account_models', 'teams_models.author_id', '=', 'admin_account_models.id')
            ->join('organisations_models', 'teams_models.organisation', '=', 'organisations_models.code_org')
            ->select(
                'organisations_models.*',
                'organisations_models.id as organisation_id',
                'admin_account_models.*',
                'admin_account_models.id as user_id',
                'teams_models.*'
            )->get();
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

    public function store(Request $request){
        try {
            if(empty($request->fname)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('nom')
                    ]
                );
            endif;
            if(empty($request->lname)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('prénoms')
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
            if(empty($request->phone)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('numéro de téléphone')
                    ]
                );
            endif;
            if(empty($request->organisation)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('organisme')
                    ]
                );
            endif;
            if(empty($request->genre)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('genre')
                    ]
                );
            endif;
            $check_user_exist = TeamsModel::Where('email', '=', $request->email)->first();
            if(!$check_user_exist):
                $add = new TeamsModel();
                $add->fname = $request->fname;
                $add->lname = $request->lname;
                $add->competences = $request->competence;
                $add->fonctions = $request->fonction;
                $add->phone = $request->phone;
                $add->email = $request->email;
                $add->author_id = $request->author_id;
                $add->profession_list = $request->profession_list;
                $add->address = $request->address;
                $add->languages = $request->languages;
                $add->nationnalite = $request->nationnalite;
                $add->pays_residence = $request->pays_residence;
                $add->lieu_residence = $request->lieu_residence;
                $add->link_linkedin = $request->link_linkedin;
                $add->link_site_web = $request->link_site_web;
                $add->organisation = $request->organisation;
                $add->category_person = $request->category_person;
                $add->genre = $request->genre;

                if(!empty($request->file)):
                    $add->person_img = UploadFileService::uploadFile($request,'file','person');
                endif;
                $add->slug = SlgGenrateService::slgGenerate();
                $add->matricule = SlgGenrateService::matriculeGenerate();
                if($add->save()){
                    return response()->json(
                        [
                            'status' => 'Succès',
                            'code' => 100,
                            'message' => MessageService::code100()
                        ]
                    );
                }else{
                    return response()->json(
                        [
                            'code' => 400,
                            'status' => 'Erreur',
                            'message' => MessageService::code400()
                        ]
                    );
                }
            else:
                return response()->json(
                    [
                        'code' => 000,
                        'status' => 'Attention',
                        'message' => "Ooops ! Le personnel existe déjà. Merci de changer de mail."
                    ]
                );
            endif;
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

    public function update(Request $request, $slg){
        try {
            if(isset($slg)){

                if(empty($request->fname)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('nom')
                        ]
                    );
                endif;
                if(empty($request->lname)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('prénoms')
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
                if(empty($request->phone)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('numéro de téléphone')
                        ]
                    );
                endif;
                if(empty($request->organisation)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('organisme')
                        ]
                    );
                endif;
                if(empty($request->genre)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('genre')
                        ]
                    );
                endif;

                $data = TeamsModel::where('slug', '=', $slg)->first();
                if($data){
                    if($data->email != $request->email):
                        $check_user_exist = TeamsModel::Where('email', '=', $request->email)->first();
                        if($check_user_exist){
                            return response()->json(
                                [
                                    'code' => 000,
                                    'status' => 'Attention',
                                    'message' => "Ooops ! Le personnel existe déjà. Merci de changer de mail."
                                ]
                            );
                        }
                    endif;
                    $data->fname = $request->fname;
                    $data->lname = $request->lname;
                    $data->fonctions = $request->fonction;
                    $data->phone = $request->phone;
                    $data->email = $request->email;
                    $data->competences = $request->competence;
                    $data->author_id = $request->author_id;
                    $data->profession_list = $request->profession_list;
                    $data->address = $request->address;
                    $data->languages = $request->languages;
                    $data->nationnalite = $request->nationnalite;
                    $data->pays_residence = $request->pays_residence;
                    $data->lieu_residence = $request->lieu_residence;
                    $data->link_linkedin = $request->link_linkedin;
                    $data->link_site_web = $request->link_site_web;
                    $data->organisation = $request->organisation;
                    $data->category_person = $request->category_person;
                    $data->genre = $request->genre;
                    if($request->file != 'undefined'):
                        $data->person_img = UploadFileService::uploadFile($request,'file','person');
                    endif;
                    // (object)
                    if($data->save()){
                        return response()->json(
                            [
                                'status' => 'Succès',
                                'code' => 200,
                                'message' => MessageService::code200(),
                            ]
                        );
                    }else{
                        return response()->json(
                            [
                                'status' => 'Erreur',
                                'code' => 400,
                                'message' => MessageService::code400(),
                            ]
                        );
                    }
                }else{
                    return response()->json(
                        [
                            'status' => 'Erreur',
                            'code' => 400,
                            'message' => MessageService::code400(),
                        ]
                    );
                }
            }else{
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 300,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }

    public function delete($slg){
        try {
            if(!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = TeamsModel::where('slug', '=', $slg)->delete();
            if($resp){
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => MessageService::code100()
                    ]
                );
            }else{
                return response()->json(
                    [
                        'code' => 400,
                        'status' => 'Erreur',
                        'message' => MessageService::code400()
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

    public function change_item_order(Request $request, $slg){
        try {
            if(!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = TeamsModel::where('slug', '=', $slg)
            ->update(['item_order' => $request->item_order]);
            if($resp){
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => MessageService::code100()
                    ]
                );
            }else{
                return response()->json(
                    [
                        'code' => 400,
                        'status' => 'Erreur',
                        'message' => MessageService::code400()
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
}
