<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Fruitcake\Cors\HandleCors;
use App\Services\MessageService;
use App\Models\AdminAccountModel;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
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
            $list = AdminAccountModel::Join('role_models', 'admin_account_models.role_id', 'role_models.id')
            ->select('role_models.role', 'admin_account_models.*')->get();
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
            if(empty($request->role_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('rôle')
                    ]
                );
            endif;
            if(empty($request->email)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('email')
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
            $check_user_exist = AdminAccountModel::Where('email', '=', $request->email)->first();
            if(!$check_user_exist):
                $add = new AdminAccountModel();
                $add->role_id = $request->role_id;
                $add->fname = $request->fname;
                $add->lname = $request->lname;
                $add->fonction = $request->fonction;
                $add->phone = $request->phone;
                $add->email = $request->email;
                if(!empty($request->file)):
                    $add->admin_img = UploadFileService::uploadFile($request,'file','admin');
                endif;
                $add->status_account = 0;
                $add->reset_password = SlgGenrateService::passwordGenerate();
                $add->slug = SlgGenrateService::slgGenerate();
                // (object)
                // return $add;
                if($add->save()){
                    $new_user = AdminAccountModel::Where('email', '=', $request->email)->first();
                    $user = new User();
                    $user->name = $new_user->fname.' '.$new_user->lname;
                    $user->user_id = $new_user->id;
                    $user->email = $new_user->email;
                    $user->password = Hash::make($new_user->reset_password);
                    $user->status_connection = 0;
                    // return $user;
                    if($user->save()){
                        return response()->json(
                            [
                                'status' => 'Succès',
                                'code' => 100,
                                'data' => [
                                    'email' => $add->email,
                                    'password' => $add->reset_password
                                ],
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
                }
            else
                return response()->json(
                    [
                        'code' => 000,
                        'status' => 'Attention',
                        'message' => "Ooops ! L'utilisateur existe déjà. Merci de changer de mail."
                    ]
                );
            endif;
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
                if(empty($request->role_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('rôle')
                        ]
                    );
                endif;
                if(empty($request->email)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('email')
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

                $data = AdminAccountModel::where('slug', '=', $slg)->first();
                if($data){
                    if($data->email != $request->email):
                        $check_user_exist = AdminAccountModel::Where('email', '=', $request->email)->first();
                        if($check_user_exist){
                            return response()->json(
                                [
                                    'code' => 000,
                                    'status' => 'Attention',
                                    'message' => "Ooops ! L'utilisateur existe déjà. Merci de changer de mail."
                                ]
                            );
                        }
                    endif;
                    $data->role_id = $request->role_id;
                    $data->fname = $request->fname;
                    $data->lname = $request->lname;
                    $data->fonction = $request->fonction;
                    $data->phone = $request->phone;
                    $data->email = $request->email;
                    if($request->file != 'undefined'):
                        $data->admin_img = UploadFileService::uploadFile($request,'file','admin');
                    endif;
                    // (object)
                    if($data->save()){
                        // return $data;
                        $user = User::Where('user_id', '=', $data->id)->first();
                        $user->name = $data->fname.' '.$data->lname;
                        $user->email = $data->email;
                        if($user->save()){
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

            $resp = AdminAccountModel::where('slug', '=', $slg)->delete();

            if($resp){
                $data = AdminAccountModel::where('admin_account_models.slug', '=', $slg)
                ->join('users', 'admin_account_models.id', '=', 'users.user_id')
                ->select('users.id')->first();

                $user = User::where('id', '=', $data->id)->delete();

                if($user){
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

    // checked

    public function checked($slg){
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

            $data = AdminAccountModel::where('slug', '=', $slg)->first();
            if($data){
                if($data->status_account == 1):
                    $resp = AdminAccountModel::where('slug', '=', $slg)->update(
                        ['status_account' => 0]
                    );
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
                else:
                    $resp = AdminAccountModel::where('slug', '=', $slg)->update(
                        ['status_account' => 1]
                    );
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
                endif;

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
