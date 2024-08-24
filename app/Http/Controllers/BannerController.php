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
            $banners = BannerModel::OrderByDesc('id')->get();
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
            if(empty($request->type_event_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('Type d\'évènement')
                    ]
                );
            endif;
            if(empty($request->description)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('Description')
                    ]
                );
            endif;
            if(empty($request->event_img)):
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
            $add->event_img = UploadFileService::uploadFile($request->event_img, 'event_img', 'banner');
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

                if(empty($request->url)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('Lien Google Meet')
                        ]
                    );
                endif;
                if(empty($request->type_event_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('Type d\'évènement')
                        ]
                    );
                endif;
                if(empty($request->description)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('Description')
                        ]
                    );
                endif;
                if(empty($request->event_img)):
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
                    if($request->event_img != 'undefined'):
                        $data->event_img = UploadFileService::uploadFile($request->event_img, 'event_img', 'banner');
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
}
