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
    //

    // 'partner',
    // 'description',
    // 'url_site',
    // 'slug'


    protected $middleware = [
        'auth:api', // Reference the middleware group
    ];

    public function __construct()
    {
        $this->middleware;
    }

    public function index(){
        try {
            $partners = PartnersModel::OrderByDesc('id')->get();
            if($partners != null){return $partners;}
            else{return $partners = '';}
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
            if(empty($request->url_site)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('url')
                    ]
                );
            endif;

            $add = new PartnersModel();
            $add->url_site = $request->url_site;
            $add->description = $request->description;
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
                if(empty($request->url_site)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('url')
                        ]
                    );
                endif;

                $data = PartnersModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->url_site = $request->url_site;
                    $data->description = $request->description;
                    if(!empty($request->partner)):
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
}
