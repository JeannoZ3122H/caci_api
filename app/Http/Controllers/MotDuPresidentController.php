<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MotDuPresidentModel;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;

class MotDuPresidentController extends Controller
{

    protected $middleware = [
        'auth:api', // Reference the middleware group
    ];

    public function __construct()
    {
        $this->middleware;
    }

    public function index()
    {
        try {
            $last_item = MotDuPresidentModel::Join('admin_account_models', 'mot_du_president_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'mot_du_president_models.*')
            ->orderByDesc('mot_du_president_models.updated_at')
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

    public function store(Request $request)
    {
        try {
            // return $request->all();
            if (empty($request->author_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('auteur')
                    ]
                );
            endif;

            $add = new MotDuPresidentModel();
            $add->author_id = $request->author_id;
            $add->president = $request->president;
            $add->poste = $request->poste;
            $add->title = $request->title;
            $add->sub_title = $request->sub_title;
            $add->description = $request->description;
            if (!empty($request->illustration)):
                $add->illustration = UploadFileService::uploadFileAny($request, 'mot_du_president', 'mot_du_president_', 'illustration');
            endif;
            $add->slug = SlgGenrateService::slgGenerate();
            // (object)
            // return $add;
            if ($add->save()) {
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'message' => MessageService::code100()
                    ]
                );
            } else {
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

    public function update(Request $request, $slg)
    {
        try {
            if (isset($slg)) {
                // return $request->all();
                if (empty($request->author_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('auteur')
                        ]
                    );
                endif;

                $data = MotDuPresidentModel::where('slug', '=', $slg)->first();
                if ($data) {
                    // return $data;
                    $data->author_id = $request->author_id;
                    $data->president = $request->president;
                    $data->poste = $request->poste;
                    $data->title = $request->title;
                    $data->sub_title = $request->sub_title;
                    $data->description = $request->description;
                    if (isset($request->illustration) && $request->illustration != 'undefined'):
                        $data->illustration = UploadFileService::uploadFileAny($request, 'mot_du_president', 'mot_du_president_', 'illustration');
                    endif;
                    if ($data->save()) {
                        return response()->json(
                            [
                                'status' => 'Succès',
                                'code' => 200,
                                'message' => MessageService::code200(),
                            ]
                        );
                    } else {
                        return response()->json(
                            [
                                'status' => 'Erreur',
                                'code' => 400,
                                'message' => MessageService::code400(),
                            ]
                        );
                    }
                } else {
                    return response()->json(
                        [
                            'status' => 'Erreur',
                            'code' => 400,
                            'message' => MessageService::code400(),
                        ]
                    );
                }
            } else {
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

    public function delete($slg)
    {
        try {
            if (!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;

            $resp = MotDuPresidentModel::where('slug', '=', $slg)->delete();
            if ($resp) {
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => MessageService::code100()
                    ]
                );
            } else {
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
    public function change_item_order(Request $request, $slg)
    {
        try {
            if (!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = MotDuPresidentModel::where('slug', '=', $slg)
                ->update(['item_order' => $request->item_order]);
            if ($resp) {
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => "L'opération a été effectuée, l'élément a été placé en position " . strval($request->item_order) . " dans la liste"
                    ]
                );
            } else {
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
