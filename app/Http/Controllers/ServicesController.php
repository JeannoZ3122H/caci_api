<?php

namespace App\Http\Controllers;

use App\Models\ServicesModel;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{

    protected $middleware = [
        'auth:api', // Reference the middleware group
    ];

    public function __construct()
    {
        $this->middleware;
    }


// ======= START =========== ======= //
// ======= =========== COMMENT DEVENIR EXPERT... =========== ======= //
public function index($type_service_id){
    try {
        if(isset($type_service_id)):
            $list = ServicesModel::Join('admin_account_models', 'services_models.author_id', '=', 'admin_account_models.id')
            ->where('services_models.type_service_id', '=', $type_service_id)
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'services_models.*')->get();
            if($list != null){return $list;}
            else{return $list = [];}
        else:
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 400,
                    'message' => MessageService::code400(),
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

        // return $request->all();
        if(empty($request->type_service_id)):
            return response()->json(
                [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('type de service')
                ]
            );
        endif;
        if(empty($request->author_id)):
            return response()->json(
                [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('auteur')
                ]
            );
        endif;
        if(empty($request->libelle)):
            return response()->json(
                [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('libellé')
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
        if(empty($request->type_media)):
            return response()->json(
                [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('type de média')
                ]
            );
        endif;

        $add = new ServicesModel();
        $add->type_service_id = $request->type_service_id;
        $add->author_id = $request->author_id;
        $add->libelle = $request->libelle;
        $add->subTitle = $request->subTitle;
        $add->type_media = $request->type_media;
        $add->code_ref = SlgGenrateService::generateCodeRef();
        $add->description = $request->description;
        if($request->type_media == "img"):
            if(!empty($request->illustration) && $request->hasFile('illustration')):
                $add->illustration = UploadFileService::uploadFile($request, 'illustration', 'docs');
            else:
                $add->illustration = null;
            endif;
        else:
            $add->illustration = $request->illustration;
        endif;
        $add->slug = SlgGenrateService::slgGenerate();

        if($add->save()){
            return response()->json(
                [
                    'status' => 'Succès',
                    'code' => 100,
                    'data' => $add->code_ref,
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
            if(empty($request->type_service_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('type de service')
                    ]
                );
            endif;

            if(empty($request->author_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('auteur')
                    ]
                );
            endif;
            if(empty($request->libelle)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('libellé')
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
            if(empty($request->type_media)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('type de média')
                    ]
                );
            endif;

            $data = ServicesModel::Where('slug', '=', $slg)->first();
            if($data){
                $data->type_service_id = $request->type_service_id;
                $data->author_id = $request->author_id;
                $data->libelle = $request->libelle;
                $data->type_media = $request->type_media;
                $data->subTitle = $request->subTitle;
                $data->description = $request->description;
                if(isset($request->illustration) && $request->hasFile('illustration')):
                    if($request->type_media == "img"):
                        $data->illustration = UploadFileService::uploadFile($request, 'illustration', 'docs');
                    else:
                        $data->illustration = $request->illustration;
                    endif;
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
        $resp = ServicesModel::where('slug', '=', $slg)->delete();
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
// ======= =========== COMMENT DEVENIR EXPERT... =========== ======= //
// ======= END =========== ======= //

}
