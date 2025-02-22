<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{

    public $pathList = [];
    protected $middleware = [
        'auth:api', // Reference the middleware group
    ];

    public function __construct()
    {
        $this->middleware;
    }

    public function index(){
        try {
            $events = EventModel::OrderBy('event_models.event_date', 'desc')
            ->join('type_event_models', 'event_models.type_event_id', '=', 'type_event_models.id')
            ->select('type_event_models.type_event', 'event_models.*')
            ->groupBy('event_models.id')
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
                        'message' => MessageService::code302('type d\'évènement')
                    ]
                );
            endif;
            if(empty($request->title)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('titre de l\'article')
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
            if(empty($request->author_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('auteur')
                    ]
                );
            endif;

            // return $request->all();
            if ($request->hasFile('files')) {
                $i = 1;
                foreach ($request->file('files') as $file) {
                    // Generate a unique filename
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'event_' . time() . '_' . uniqid() . '.' . $extension;

                    // Define the path where the file will be stored
                    $path = 'media/event_img/';

                    // Move the file to the defined path
                    $file->move(public_path($path), $filename);
                    // return url('/') . '/' . $path . $filename;
                    $data = [
                        'id' => $i++, // L'équivalent de `this.pondFiles.length + 1` en PHP
                        'file' => url('/') . '/' . $path . $filename   // L'équivalent de `fileItem.file.file`
                    ];
                    $json = response()->json($data)->original;
                    // Generate the image URL and add to the array
                    // $this->pathList[] = response(json_encode($data), 200, ['Content-Type' => 'application/json']);
                    $this->pathList[] = $json;
                }
            }

            $add = new EventModel();
            $add->author_id = $request->author_id;
            $add->type_event_id = $request->type_event_id;
            $add->event_description = $request->description;
            $add->event_title = $request->title;
            $add->event_date = $request->date;
            $add->event_img = json_encode($this->pathList);
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
                            'message' => MessageService::code302('type d\'évènement')
                        ]
                    );
                endif;
                if(empty($request->title)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('titre de l\'article')
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
                if(empty($request->author_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('auteur')
                        ]
                    );
                endif;

                $data = EventModel::Where('slug', '=', $slg)->first();
                if($data){

                    $data->author_id = $request->author_id;
                    $data->type_event_id = $request->type_event_id;
                    $data->event_description = $request->description;
                    $data->event_date = $request->date;
                    $data->event_title = $request->title;

                    // return $request->all();
                    if (!empty($request->status_is)) {
                        if($request->status_is == 'global_update'){
                            if ($request->hasFile('files')) {
                                $i = 1;
                                foreach ($request->file('files') as $file) {
                                    // Generate a unique filename
                                    $extension = $file->getClientOriginalExtension();
                                    $filename = 'event_' . time() . '_' . uniqid() . '.' . $extension;
                                    // Define the path where the file will be stored
                                    $path = 'media/event_img/';
                                    // Move the file to the defined path
                                    $file->move(public_path($path), $filename);
                                    // return url('/') . '/' . $path . $filename;
                                    $data = [
                                        'id' => $i++, // L'équivalent de `this.pondFiles.length + 1` en PHP
                                        'file' => url('/') . '/' . $path . $filename   // L'équivalent de `fileItem.file.file`
                                    ];
                                    $json = response()->json($data)->original;
                                    $this->pathList[] = $json;
                                }
                            }
                            $data->event_img = json_encode($this->pathList);
                        }elseif($request->status_is == 'only_update'){
                            $nbre = 0;
                            $all_item_update = json_decode($request->all_item_update);
                            $all_item_old_add = json_decode($data->event_img);
                            // return $request->hasFile('files');
                            if ($request->hasFile('files')) {
                                foreach ($request->file('files') as $file) {
                                    // Generate a unique filename
                                    $extension = $file->getClientOriginalExtension();
                                    $filename = 'event_' . time() . '_' . uniqid() . '.' . $extension;
                                    // Define the path where the file will be stored
                                    $path = 'media/event_img/';
                                    // Move the file to the defined path
                                    $file->move(public_path($path), $filename);
                                    // $json = response()->json($data)->original;
                                    $this->pathList[] = url('/') . '/' . $path . $filename  ;
                                }
                            }

                            for ($i=0; $i < sizeof($all_item_update); $i++) {
                                if($all_item_update[$i]){
                                    $item = $all_item_update[$i];
                                    foreach ($all_item_old_add as $media) {
                                        if($media->id === $item->id) {
                                            $media->file = $this->pathList[$nbre];
                                            $nbre++;
                                        }
                                    }
                                }
                            }
                            $data->event_img = json_encode($all_item_old_add);
                        }
                    }
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
            $resp = EventModel::where('slug', '=', $slg)
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
