<?php

namespace App\Http\Controllers;

use App\Models\FolderUsModel;
use App\Models\analyseFolderModel;
use App\Models\NewsLettersModel;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;

class messageController extends Controller
{

    protected $middleware = [
        'auth:api', ['except' => ['store']]
    ];

    public function __construct()
    {
        $this->middleware;
    }

    public function index(){
        try {

            $list_folder_us = FolderUsModel::OrderByDesc('id')
            ->join('type_procedure_models', 'folder_us_models.type_procedure_id', 'type_procedure_models.id')
            ->select('type_procedure_models.type_procedure', 'folder_us_models.*')
            ->with('analyse')
            ->where('status_answere', '=', 0)
            ->get()->map(function ($folder) {
                return [
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
            });




            $list_folder_us_answere = FolderUsModel::OrderByDesc('id')
            ->join('type_procedure_models', 'folder_us_models.type_procedure_id', 'type_procedure_models.id')
            ->select('type_procedure_models.type_procedure', 'folder_us_models.*')
            ->with('analyse')
            ->where('status_answere', '=', 1)
            ->get()->map(function ($folder) {
                return [
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
            });

            if($list_folder_us_answere != null || $list_folder_us != null){
                return response()->json(
                    [
                        'list_folder_us' => $list_folder_us,
                        'list_folder_us_answere' => $list_folder_us_answere
                    ]
                );
            }else{
                return response()->json(
                    [
                        'list_folder_us' => $list_folder_us,
                        'list_folder_us_answere' => $list_folder_us_answere
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

    public function get_old_list_analyse($ref_dossier){
        try {
            if(isset($ref_dossier)):
                $list = analyseFolderModel::OrderByDesc('id')
                ->where('ref_dossier', '=', $ref_dossier)
                ->get();
                if($list != null){
                    return $list;
                }else{
                    return $list = [];
                }
            else:
                return response()->json(
                    [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => "Aucune donnée reçue pour traiter. Merci de fournie !"
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

    public function store(Request $request){

        try {

            if(empty($request->author_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('l\'auteur')
                    ]
                );
            endif;
            if(empty($request->type_procedure_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('type de procédure')
                    ]
                );
            endif;
            if(empty($request->ref_folder)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('référence du dossier')
                    ]
                );
            endif;
            if(empty($request->fullname)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('nom complet du propriétaire du dossier')
                    ]
                );
            endif;
            if(empty($request->dossier_follower)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('responsable du dossier')
                    ]
                );
            endif;
            if(empty($request->status_folder_analyse)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('status d\'analyse du dossier')
                    ]
                );
            endif;

            $add = new FolderUsModel();
            $add->author_id = $request->author_id;
            $add->dossier_follower = $request->dossier_follower;
            $add->type_procedure_id = $request->type_procedure_id;
            $add->fullname = $request->fullname;
            $add->email = $request->email;
            $add->tel = $request->tel;
            $add->professions = $request->professions;
            $add->status_folder_analyse = $request->status_folder_analyse;
            $add->already_step = $request->current_step;
            $add->status_finished = 0;
            $add->status_answere = 0;
            $add->description = $request->description;
            $add->ref_folder = $request->ref_folder;
            if($request->file != null && !empty($request->file)):
                $add->file = UploadFileService::uploadFile($request, 'file', 'docs');
            endif;
            $add->slug = SlgGenrateService::slgGenerate();

            // return $add;
            if($add->save()){
                $add_analyse = new analyseFolderModel();
                $add_analyse->author_id = $request->author_id;
                $add_analyse->folder_us_id = $add->id;
                $add_analyse->object = $request->object;
                $add_analyse->comments = $request->comments;
                $add_analyse->current_step = $request->current_step;
                $add_analyse->next_step = $request->next_step;
                $add_analyse->next_step_date = $request->next_step_date;
                $add_analyse->status_analyse = $request->status_folder_analyse;
                $add_analyse->slug = SlgGenrateService::slgGenerate();
                // return $add_analyse;
                if($add_analyse->save()):
                    return response()->json(
                        [
                            'status' => 'Succès',
                            'code' => 100,
                            'message' => MessageService::code100()
                        ]
                    );
                else:
                    return response()->json(
                        [
                            'status' => 'Erreur',
                            'code' => 400,
                            'message' => MessageService::code400()
                        ]
                    );
                endif;
            }else{
                return response()->json(
                    [
                        'status' => 'Erreur',
                        'code' => 400,
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

    public function update(Request $request, $slg){
        try {
            if($slg):
                $data = FolderUsModel::Where('slug', $slg)->first();
                if($data):
                    $update_message = FolderUsModel::Where('slug', $slg)
                    ->update([
                        'status_folder_analyse' => $request->status_folder_analyse,
                        'already_step' => $request->current_step,
                        'dossier_follower' => $request->dossier_follower,
                        'type_procedure_id' => $request->type_procedure_id,
                        'fullname' => $request->fullname,
                        'email' => $request->email,
                        'tel' => $request->tel,
                        'professions' => $request->professions,
                        'description' => $request->description,
                        'status_answere' => 1,
                    ]);
                    if($update_message):
                        $add_analyse = new analyseFolderModel();
                        $add_analyse->author_id = $request->author_id;
                        $add_analyse->folder_us_id = $data->id;
                        $add_analyse->object = $request->object;
                        $add_analyse->comments = $request->comments;
                        $add_analyse->current_step = $request->current_step;
                        $add_analyse->next_step = $request->next_step;
                        $add_analyse->next_step_date = $request->next_step_date;
                        $add_analyse->status_analyse = $request->status_folder_analyse;
                        $add_analyse->slug = SlgGenrateService::slgGenerate();
                        if($add_analyse->save()):
                            return response()->json(
                                [
                                    'status' => 'Succès',
                                    'code' => 200,
                                    'data' => $add_analyse,
                                    'message' => MessageService::code100()
                                ]
                            );
                        else:
                            return response()->json(
                                [
                                    'status' => 'Erreur',
                                    'code' => 400,
                                    'message' => MessageService::code400()
                                ]
                            );
                        endif;
                    else:
                        return response()->json(
                            [
                                'status' => 'Erreur',
                                'code' => 400,
                                'message' => MessageService::code400()
                            ]
                        );
                    endif;
                else:
                    return response()->json(
                        [
                            'status' => 'Erreur',
                            'code' => 400,
                            'message' => MessageService::code400()
                        ]
                    );
                endif;
            else:
                return response()->json(
                    [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => "Aucune donnée reçue pour traiter. Merci de fournie !"
                    ]
                );
            endif;
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
            $resp = FolderUsModel::where('slug', '=', $slg)->delete();
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

    public function check(Request $request, $slg){
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
            $resp = FolderUsModel::where('slug', '=', $slg)->update(
                [
                    'status_answere' => 1,
                    'author_id' => $request->author_id
                ]
            );
            if($resp){
                return response()->json(
                    [
                        'code' => 200,
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

    public function finished(Request $request, $slg){
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
            $resp = FolderUsModel::where('slug', '=', $slg)->update(
                [
                    'status_finished' => 1
                ]
            );
            if($resp){
                return response()->json(
                    [
                        'code' => 200,
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

