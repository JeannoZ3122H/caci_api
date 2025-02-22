<?php

namespace App\Http\Controllers;

use App\Models\TestimonialsModel;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;

class TestimonialsController extends Controller
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
            $list = TestimonialsModel::all();
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

    public function store(Request $request){
        try {
            // return $request->all();
            if(empty($request->fname)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('nom')
                    ]
                );
            endif;
            if(empty($request->lname)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('prénoms')
                    ]
                );
            endif;
            if(empty($request->fonction)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('fonction')
                    ]
                );
            endif;
            if(empty($request->phone)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('numéro de téléphone')
                    ]
                );
            endif;
            if(empty($request->description)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('description')
                    ]
                );
            endif;

            $add = new TestimonialsModel();
            $add->fname = $request->fname;
            $add->lname = $request->lname;
            $add->fonction = $request->fonction;
            $add->phone = $request->phone;
            $add->description = $request->description;
            if(!empty($request->illustration)):
                $add->illustration = UploadFileService::uploadFile($request,'file','admin');
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

    public function update(Request $request, $slg){
        try {
            if(isset($slg)){
                if(empty($request->fname)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('nom')
                        ]
                    );
                endif;
                if(empty($request->lname)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('prénoms')
                        ]
                    );
                endif;
                if(empty($request->fonction)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('fonction')
                        ]
                    );
                endif;
                if(empty($request->phone)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('numéro de téléphone')
                        ]
                    );
                endif;
                if(empty($request->description)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('description')
                        ]
                    );
                endif;

                $data = TestimonialsModel::where('slug', '=', $slg)->first();
                if($data){
                    $data->role_id = $request->role_id;
                    $data->fname = $request->fname;
                    $data->lname = $request->lname;
                    $data->fonction = $request->fonction;
                    $data->phone = $request->phone;
                    $data->email = $request->email;
                    if($request->file != 'undefined'):
                        $data->admin_img = UploadFileService::uploadFile($request,'file','admin');
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

            $resp = TestimonialsModel::where('slug', '=', $slg)->delete();

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
