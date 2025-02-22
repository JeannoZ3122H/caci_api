<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PartnersModel;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use Illuminate\Http\Request;

class PartnersController extends Controller
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
            $partners = PartnersModel::OrderBy('item_order', 'asc')->groupBy('id', 'item_order')->get();
            $status_favorite = PartnersModel::where('is_favorited', '=', 1)->first();

            if($partners != null){
                return response()->json(
                    [
                        'list' => $partners,
                        'status_favorite' => !$status_favorite?0:1,
                    ]
                );
            }
            else{
                return response()->json(
                    [
                        'list' => [],
                        'status_favorite' => !$status_favorite?0:1,
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

    public function store(Request $request){
        try {
            if(empty($request->description)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('description')
                    ]
                );
            endif;
            if(empty($request->partner)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('logo du parténairte')
                    ]
                );
            endif;
            if(empty($request->title)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('le titre')
                    ]
                );
            endif;

            $add = new PartnersModel();
            $add->url_site = $request->url_site;
            $add->description = $request->description;
            $add->title = $request->title;
            if(!empty($request->partner)):
                $add->partner = UploadFileService::uploadFile($request, 'partner', 'partner');
            endif;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()){
                return response()->json(
                    [
                        'status' => 'Erreur',
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

    public function update(Request $request, $slg){
        try {
            if(isset($slg)){
                if(empty($request->description)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('description')
                        ]
                    );
                endif;
                if(empty($request->partner)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('logo du parténairte')
                        ]
                    );
                endif;
                if(empty($request->title)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('le titre')
                        ]
                    );
                endif;

                $data = PartnersModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->url_site = $request->url_site;
                    $data->description = $request->description;
                    $data->title = $request->title;
                    if($request->partner != 'undefined'):
                        $data->partner = UploadFileService::uploadFile($request, 'partner', 'partner');
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
            $resp = PartnersModel::where('slug', '=', $slg)->delete();
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

    public function declared_partner_into_favorite($slg){
        try {
            if(!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => "L'opération a échoué ! l'élément n'est pas trouvable dans la liste."
                    ]
                );
            endif;

            $check_is_exist_favorite_partner = PartnersModel::where('is_favorited', '=', 1)->first();
            if(!$check_is_exist_favorite_partner){
                $resp = PartnersModel::where('slug', '=', $slg)
                ->update(['is_favorited' => 1]);
                if($resp){
                    return response()->json(
                        [
                            'code' => 100,
                            'status' => 'Succès',
                            'message' => "L'élément est marqué dans la liste des partenaires comme favoris."
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
            }else{
                $is_already_favorite_partner = PartnersModel::where('is_favorited',  1)
                ->where('slug', '=', $slg)->first();

                if(!$is_already_favorite_partner){
                    $uncheck_partner_is_already_favorite_partner = PartnersModel::where('is_favorited',  1)
                    ->update(['is_favorited' => 0]);

                    if($uncheck_partner_is_already_favorite_partner){
                        $resp = PartnersModel::where('slug', '=', $slg)
                        ->update(['is_favorited' => 1]);
                        if($resp){
                            return response()->json(
                                [
                                    'code' => 100,
                                    'status' => 'Succès',
                                    'message' => "L'élément est marqué dans la liste des partenaires comme favoris."
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
                    }else{
                        return response()->json(
                            [
                                'code' => 300,
                                'status' => 'Attention',
                                'message' => "Il existe déjà un élément dans la liste des partenaires favoris."
                            ]
                            );
                    }
                }else{
                    $resp = PartnersModel::where('slug', '=', $slg)
                    ->update(['is_favorited' => 0]);
                    if($resp){
                        return response()->json(
                            [
                                'code' => 100,
                                'status' => 'Succès',
                                'message' => "L'élément n'est plu marqué comme favoris dans la liste des partenaires."
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
                }
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
                        'message' => "L'opération a été effectuée, l'élément a été placé en position ".strval($request->item_order)." dans la liste"
                    ]
                );
            endif;
            $resp = PartnersModel::where('slug', '=', $slg)
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
