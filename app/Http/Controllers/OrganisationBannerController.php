<?php

namespace App\Http\Controllers;

use App\Models\OrganisationBannerModel;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Http\Controllers\Controller;
use App\Services\UploadFileService;
use Illuminate\Support\Facades\URL;

class OrganisationBannerController extends Controller
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
            $list = OrganisationBannerModel::all();
            if($list != null){return $list;}
            else{return $list = '';}
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

            if(empty($request->type_media)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('type de média')
                    ]
                );
            endif;
            if(empty($request->illustration)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('illustration(image)')
                    ]
                );
            endif;

            $add = new OrganisationBannerModel();

            if(!empty($request->illustration) && $request->type_media != "youtube"):
                if($request->hasFile('illustration')):
                    $file = $request->file('illustration');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'illustration'.time().'.'.$extension;
                    if($filename):
                        $pulic_path = 'media/banner_img/';
                        $file->move(public_path($pulic_path) , $filename);
                    else:
                        return "error";
                    endif;
                    $path = $pulic_path;
                    $image_url = URL::to('').'/'.$path.$filename;
                    $add->illustration = $image_url;
                endif;
            else:
                $add->illustration = $request->illustration;
            endif;

            $add->title = $request->title;
            $add->type_media = $request->type_media;
            $add->description = $request->description;
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
                $data = OrganisationBannerModel::Where('slug', '=', $slg)->first();
                if($data){

                    if(!empty($request->illustration) && $request->type_media != "youtube"):
                        if($request->hasFile('illustration')):
                            $file = $request->file('illustration');
                            $extension = $file->getClientOriginalExtension();
                            $filename = 'illustration'.time().'.'.$extension;
                            if($filename):
                                $pulic_path = 'media/banner_img/';
                                $file->move(public_path($pulic_path) , $filename);
                            else:
                                return "error";
                            endif;
                            $path = $pulic_path;
                            $image_url = URL::to('').'/'.$path.$filename;
                            $data->illustration = $image_url;
                        endif;
                    else:
                        $data->illustration = $request->illustration;
                    endif;

                    $data->title = $request->title;
                    $data->type_media = $request->type_media;
                    $data->description = $request->description;

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
            $resp = OrganisationBannerModel::where('slug', '=', $slg)->delete();
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
