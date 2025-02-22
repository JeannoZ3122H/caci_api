<?php

namespace App\Http\Controllers;

use App\Models\messageModel;
use Illuminate\Http\Request;
use App\Models\NewsLettersModel;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Http\Controllers\Controller;

class NewsLettersController extends Controller
{

    protected $middleware = [
        'auth:api', ['except' => ['store']]
    ];

    public function __construct()
    {
        $this->middleware;
    }

    public function index(){
        try {
            $list_nous_saisir = messageModel::OrderByDesc('id')->get();
            $list_newsletters = NewsLettersModel::OrderByDesc('id')->get();

            if($list_nous_saisir != null && $list_newsletters != null)
            {
                return response()->json(
                    [
                        'list_nous_saisir' => $list_nous_saisir,
                        'list_newsletters' => $list_newsletters
                    ]
                );
            } else
            {
                return response()->json(
                    [
                        'list_nous_saisir' => [],
                        'list_newsletters' => []
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
            if(empty($request->subscriber_email)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('l\'email')
                    ]
                );
            endif;

            $add = new NewsLettersModel();
            $add->subscriber_email = $request->subscriber_email;
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
                if(empty($request->subscriber_email)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('l\'email')
                        ]
                    );
                endif;
                $data = NewsLettersModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->subscriber_email = $request->subscriber_email;
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

    public function delete($id, $item){
        try {
            if(!isset($id)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            if($item == 1) $resp = NewsLettersModel::where('id', '=', $id)->delete();
            if($item == 2) $resp = messageModel::where('id', '=', $id)->delete();
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

    public function confirm_read($slg){
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
            $resp = messageModel::where('slug', '=', $slg)->update(
                [
                    'status_answere' => 1,
                    'status' => 1,
                    'status_contact' => 'Consulter',
                ]
            );
            if($resp){
                return response()->json(
                    [
                        'code' => 200,
                        'status' => 'Succès',
                        'data' => messageModel::where('slug', '=', $slg)->first(),
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
