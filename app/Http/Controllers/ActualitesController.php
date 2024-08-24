<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendasModels;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use App\Http\Controllers\Controller;

class ActualitesController extends Controller
{

    protected $middleware = [
        'auth:api', // Reference the middleware group
    ];

    public function __construct()
    {
        $this->middleware;
    }


// ======= START =========== ======= //
// ======= =========== AGENDAS =========== ======= //
    public function index_agenda(){
        try {
            $list = AgendasModels::Join('admin_account_models', 'agendas_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'agendas_models.*')->get();
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


    public function store_agenda(Request $request){
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
            if(empty($request->title_event)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('titre')
                    ]
                );
            endif;
            if(empty($request->description_event)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('description')
                    ]
                );
            endif;
            if(empty($request->date_start_event)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('date de début')
                    ]
                );
            endif;
            if(empty($request->date_end_event)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('date de fin')
                    ]
                );
            endif;
            if(empty($request->status_enter_event)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('statut d\'entrée')
                    ]
                );
            endif;
            if(empty($request->address_event)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('adresse')
                    ]
                );
            endif;
            if(empty($request->localisation_event)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('localisation')
                    ]
                );
            endif;
            if(empty($request->illusration_event)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('illustration')
                    ]
                );
            endif;

            $add = new AgendasModels();
            $add->author_id = $request->author_id;
            $add->title_event = $request->title_event;
            $add->description_event = $request->description_event;
            $add->date_start_event = $request->date_start_event;
            $add->date_end_event = $request->date_end_event;
            $add->status_enter_event = $request->status_enter_event;
            $add->address_event = $request->address_event;
            $add->localisation_event = $request->localisation_event;
            $add->price = $request->price;
            $add->illusration_event = $request->illusration_event;
            if($request->url_file != 'null' && !empty($request->illusration_event)):
                $add->illusration_event = UploadFileService::uploadFile($request, 'illusration_event', 'docs');
            else:
                $add->illusration_event = null;
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

    public function update_agenda(Request $request, $slg){
        try {
            if(isset($slg)){

                if(empty($request->author_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('auteur')
                        ]
                    );
                endif;
                if(empty($request->title_event)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('titre')
                        ]
                    );
                endif;
                if(empty($request->description_event)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('description')
                        ]
                    );
                endif;
                if(empty($request->date_start_event)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('date de début')
                        ]
                    );
                endif;
                if(empty($request->date_end_event)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('date de fin')
                        ]
                    );
                endif;
                if(empty($request->status_enter_event)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('statut d\'entrée')
                        ]
                    );
                endif;
                if(empty($request->address_event)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('adresse')
                        ]
                    );
                endif;
                if(empty($request->localisation_event)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('localisation')
                        ]
                    );
                endif;
                if(empty($request->illusration_event)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('illustration')
                        ]
                    );
                endif;

                $data = AgendasModels::Where('slug', '=', $slg)->first();
                if($data){
                    $data->author_id = $request->author_id;
                    $data->title_event = $request->title_event;
                    $data->description_event = $request->description_event;
                    $data->date_start_event = $request->date_start_event;
                    $data->date_end_event = $request->date_end_event;
                    $data->status_enter_event = $request->status_enter_event;
                    $data->price = $request->price;
                    $data->address_event = $request->address_event;
                    $data->localisation_event = $request->localisation_event;
                    $data->illusration_event = $request->illusration_event;
                    if($request->illusration_event != 'null' && $request->illusration_event != 'undefined' && !empty($request->illusration_event)):
                        $data->illusration_event = UploadFileService::uploadFile($request, 'illusration_event', 'docs');
                    endif;
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

    public function delete_agenda($slg){
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
            $resp = AgendasModels::where('slug', '=', $slg)->delete();
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
// ======= =========== AGENDAS =========== ======= //
// ======= END =========== ======= //

}
