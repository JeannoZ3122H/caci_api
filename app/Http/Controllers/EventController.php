<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;

class EventController extends Controller
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
            $events = EventModel::OrderByDesc('event_models.id')
            ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'event_models.*')
            ->get();
            if($events != null){return $events;}
            else{return $events = [];}
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
            if(empty($request->type_event_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('Lien Google Meet')
                    ]
                );
            endif;
            if(empty($request->title)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('Lien Google Meet')
                    ]
                );
            endif;
            if(empty($request->description)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('Type d\'évènement')
                    ]
                );
            endif;
            if(empty($request->event_img_0)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('Description')
                    ]
                );
            endif;
            if(empty($request->author)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('illustration(image)')
                    ]
                );
            endif;

            $add = new EventModel();
            $add->author = $request->author;
            $add->type_event_id = $request->type_event_id;
            $add->event_description = $request->event_description;
            $add->event_title = $request->event_title;

            if(!empty($request->event_img_0)):
                $file = UploadFileService::uploadFileMultiple($request);
                if($file == "error"):
                    return response()->json(
                        [
                            'code' => 400,
                            'status' => 'Erreur',
                            'message' => MessageService::code400()
                        ]
                    );
                else:
                    $add->event_img = json_encode($file);
                endif;
            endif;
            $add->slug = SlgGenrateService::slgGenerate();
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

                if(empty($request->type_event_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('Lien Google Meet')
                        ]
                    );
                endif;
                if(empty($request->event_title)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('Lien Google Meet')
                        ]
                    );
                endif;
                if(empty($request->event_description)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('Type d\'évènement')
                        ]
                    );
                endif;
                if(empty($request->event_img_0)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('Description')
                        ]
                    );
                endif;
                if(empty($request->author)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('illustration(image)')
                        ]
                    );
                endif;

                $data = EventModel::Where('slug', '=', $slg)->first();
                if($data){

                    $data->author = $request->author;
                    $data->type_event_id = $request->type_event_id;
                    $data->event_description = $request->event_description;
                    $data->event_title = $request->event_title;
                    if(!empty($request->event_img_0)):
                        $file = UploadFileService::uploadFileMultiple($request);
                        if($file == "error"):
                            return response()->json(
                                [
                                    'code' => 400,
                                    'status' => 'Erreur',
                                    'message' => MessageService::code400()
                                ]
                            );
                        else:
                            $data->event_img = json_encode($file);
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
            $resp = EventModel::where('slug', '=', $slg)->delete();
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
