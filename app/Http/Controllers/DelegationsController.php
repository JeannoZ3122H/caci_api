<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DelegationModel;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;

class DelegationsController extends Controller
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

            $list = DelegationModel::OrderBy('delegation_models.item_order', 'asc')
            ->join('teams_models', 'delegation_models.representant_id', '=', 'teams_models.id')
            ->select('teams_models.*', 'delegation_models.*')
            ->groupBy('delegation_models.id', 'delegation_models.item_order')
            ->get();

            if ($list != null) {
                return $list;
            } else {
                return $list = [];
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

    public function store(Request $request)
    {
        try {
            if (empty($request->representant_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('representant(e)')
                    ]
                );
            endif;
            if (empty($request->author_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('auteur')
                    ]
                );
            endif;
            if (empty($request->libelle)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('nom de la délégation')
                    ]
                );
            endif;

            $add = new DelegationModel();
            $add->author_id = $request->author_id;
            $add->libelle = $request->libelle;
            $add->delegation_address = $request->address;
            $add->url_google_map = $request->url_google_map;
            $add->phone = $request->phone;
            $add->representant_id = $request->representant_id;
            $add->fax = $request->fax;
            $add->email = $request->email;
            $add->url_google_map_safe = $request->url_google_map_safe;
            $add->iframe_google_map = $request->iframe_google_map;
            $add->slug = SlgGenrateService::slgGenerate();
            
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
                if (empty($request->representant_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('representant(e)')
                        ]
                    );
                endif;
                if (empty($request->author_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('auteur')
                        ]
                    );
                endif;
                if (empty($request->libelle)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('nom de la délégation')
                        ]
                    );
                endif;
                if (empty($request->url_google_map)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('lien google map')
                        ]
                    );
                endif;

                $data = DelegationModel::where('slug', '=', $slg)->first();
                if ($data) {
                    $data->author_id = $request->author_id;
                    $data->representant_id = $request->representant_id;
                    $data->libelle = $request->libelle;
                    $data->url_google_map = $request->url_google_map;
                    $data->phone = $request->phone;
                    $data->fax = $request->fax;
                    $data->delegation_address = $request->address;
                    $data->email = $request->email;
                    $data->url_google_map_safe = $request->url_google_map_safe;
                    $data->iframe_google_map = $request->iframe_google_map;
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

            $resp = DelegationModel::where('slug', '=', $slg)->delete();
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
            $resp = DelegationModel::where('slug', '=', $slg)
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
