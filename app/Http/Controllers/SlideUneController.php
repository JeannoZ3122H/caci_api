<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SlideUneModel;
use App\Services\MessageService;
use App\Services\UploadFileService;
use App\Http\Controllers\Controller;
use App\Services\SlgGenrateService;

class SlideUneController extends Controller
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
            $slide_unes = SlideUneModel::OrderByDesc('id')->get();
            if($slide_unes != null){return $slide_unes;}
            else{return $slide_unes = '';}
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
                        'message' => MessageService::code302('Description')
                    ]
                );
            endif;
            if(empty($request->slide_img)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('illustration(image)')
                    ]
                );
            endif;
            if(empty($request->title)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('titre')
                    ]
                );
            endif;

            $add = new SlideUneModel();
            $add->title = $request->title;
            $add->description = $request->description;
            if(!empty($request->slide_img)):
                $add->slide_img = UploadFileService::uploadFile($request, 'slide_img', 'slide');
            endif;
            $add->slug = SlgGenrateService::slgGenerate();
            // return $add;
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

    public function update(Request $request, $slg){
        try {
            if(isset($slg)){

                if(empty($request->description)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('Description')
                        ]
                    );
                endif;
                if(empty($request->slide_img)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('illustration(image)')
                        ]
                    );
                endif;
                if(empty($request->title)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('titre')
                        ]
                    );
                endif;

                $data = SlideUneModel::Where('slug', '=', $slg)->first();
                if($data){

                    $data->title = $request->title;
                    $data->description = $request->description;
                    if(!empty($request->slide_img)):
                        $data->slide_img = UploadFileService::uploadFile($request, 'slide_img', 'slide');
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
            $resp = SlideUneModel::where('slug', '=', $slg)->delete();
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
