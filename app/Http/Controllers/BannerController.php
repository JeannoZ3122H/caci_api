<?php

namespace App\Http\Controllers;

use App\Models\BannerModel;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Http\Controllers\Controller;
use App\Services\UploadFileService;

class BannerController extends Controller
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
            $banners = BannerModel::OrderByDesc('id')
            ->join('type_event_models', 'banner_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'banner_models.*')
            ->get();
            if($banners != null){return $banners;}
            else{return $banners = '';}
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
            if(empty($request->url)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('Lien Google Meet')
                    ]
                );
            endif;
            if(empty($request->event_illustration)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('illustration(image)')
                    ]
                );
            endif;

            $add = new BannerModel();
            $add->url = $request->url;
            $add->type_event_id = $request->type_event_id;
            $add->description = $request->description;
            $add->title = $request->title;
            $add->type_media = $request->type_media;

            if($request->type_media != "youtube" && $request->event_illustration != 'undefined' && !empty($request->event_illustration)):
                $add->event_illustration = UploadFileService::uploadFile($request, 'event_illustration', 'banner');
            else:
                $add->event_illustration = $request->event_illustration;
            endif;
            $add->slug = SlgGenrateService::slgGenerate();
            // return $add;
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

                if(empty($request->url)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('Lien Google Meet')
                        ]
                    );
                endif;
                if(empty($request->event_illustration)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('illustration(image)')
                        ]
                    );
                endif;

                $data = BannerModel::Where('slug', '=', $slg)->first();
                if($data){

                    $data->url = $request->url;
                    $data->type_event_id = $request->type_event_id;
                    $data->description = $request->description;
                    $data->title = $request->title;
                    $data->type_media = $request->type_media;
                    if($request->type_media != "youtube" && $request->event_illustration != 'undefined' && !empty($request->event_illustration)):
                        $data->event_illustration = UploadFileService::uploadFile($request, 'event_illustration', 'banner');
                    else:
                        $data->event_illustration = $request->event_illustration;
                    endif;

                    // return $data;
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
            $resp = BannerModel::where('slug', '=', $slg)->delete();
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
            $resp = BannerModel::where('slug', '=', $slg)
            ->update(['item_order' => $request->item_order]);
            if($resp){
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => "L'opération a été effectuée, l'élément a été placé en position ".strval($request->item_order)." dans la liste"
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
