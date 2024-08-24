<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Models\PublicarionsModels;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use App\Models\TypePublicationModel;

class RessourcesController extends Controller
{
    protected $middleware = [
        'auth:api', // Reference the middleware group
    ];

    public function __construct()
    {
        $this->middleware;
    }


// ======= START =========== ======= //
// ======= =========== TYPES PUBLICATIONS DETAILS =========== ======= //
    public function index_type_publication(){
        try {
            $roles = TypePublicationModel::all();
            if($roles != null){return $roles;}
            else{return $roles = [];}
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

    public function store_type_publication(Request $request){
        try {

            if(empty($request->type_publication)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('rôle')
                    ]
                );
            endif;

            $add = new TypePublicationModel();
            $add->type_publication = $request->type_publication;
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

    public function update_type_publication(Request $request, $slg){
        try {
            if(isset($slg)){
                $data = TypePublicationModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->type_publication = $request->type_publication;
                    if($data->save()){
                        return response()->json(
                            [
                                'status' => 'Succès',
                                'code' => 200,
                                'message' => MessageService::code200(),
                            ]
                        );
                    };
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

    public function delete_type_publication($slg){
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
            $resp = TypePublicationModel::where('slug', '=', $slg)->delete();
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
// ======= =========== TYPES PUBLICATIONS DETAILS =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== PUBLICATIONS DETAILS =========== ======= //
    public function index_publication(){
        try {
            $list = PublicarionsModels::Join('admin_account_models', 'publicarions_models.author_id', '=', 'admin_account_models.id')
            ->join('type_publication_models', 'publicarions_models.type_publication_id', '=', 'type_publication_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'type_publication_models.type_publication', 'publicarions_models.*')
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
    public function store_publication(Request $request){
        try {
            if(empty($request->author_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('auteur')
                    ]
                );
            endif;
            if(empty($request->type_publication_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('type de publication')
                    ]
                );
            endif;
            if(empty($request->type_file)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('format de publication')
                    ]
                );
            endif;
            if(empty($request->libelle)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('libelle')
                    ]
                );
            endif;
            if(empty($request->url) && empty($request->url_file)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('url ou fichier')
                    ]
                );
            endif;

            $add = new PublicarionsModels();
            $add->author_id = $request->author_id;
            $add->type_publication_id = $request->type_publication_id;
            $add->type_file = $request->type_file;
            $add->libelle = $request->libelle;
            $add->url = $request->url != 'null'?$request->url:null;
            if($request->url_file != 'null' && $request->type_file == "true"):
                $add->url_file = UploadFileService::uploadFileAny($request,'publications', 'publication_','url_file');
            else:
                $add->url_file = null;
            endif;
            $add->slug = SlgGenrateService::slgGenerate();
            // (object)
            // return $add;
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
    public function update_publication(Request $request, $slg){
        try {
            if(isset($slg)){
                // return $request->all();
                if(empty($request->author_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('auteur')
                        ]
                    );
                endif;
                if(empty($request->type_publication_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('type de publivcation')
                        ]
                    );
                endif;
                if(empty($request->libelle)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('libelle')
                        ]
                    );
                endif;
                if(empty($request->url) && empty($request->url_file)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('url ou fichier')
                        ]
                    );
                endif;
                if(empty($request->type_file)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('format de publication')
                        ]
                    );
                endif;

                $data = PublicarionsModels::where('slug', '=', $slg)->first();
                if($data){
                    // return $data;
                    $data->author_id = $request->author_id;
                    $data->type_publication_id = $request->type_publication_id;
                    $data->libelle = $request->libelle;
                    $data->type_file = $request->type_file;
                    $data->url = $request->url != 'null'?$request->url:null;
                    if($request->url_file != 'null' && $request->url_file != 'undefined' && $request->type_file == "true"):
                        $data->url_file = UploadFileService::uploadFileAny($request,'publications', 'publication_','url_file');
                    endif;
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
    public function delete_publication($slg){
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

            $resp = PublicarionsModels::where('slug', '=', $slg)->delete();
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
// ======= =========== PUBLICATIONS DETAILS =========== ======= //
// ======= END =========== ======= //


}
