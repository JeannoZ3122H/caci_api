<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlashMessages;
use App\Services\MessageService;

use App\Mail\ForgetPasswordMailer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AdminAccountModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth as JWTOld;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    protected $middleware = [
        'auth:api', ['except' => ['logIn', 'checkOldConnection']]
    ];
    /**
     * Crée une nouvelle instance du contrôleur.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware;
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function un_authorised()
    {
        return response()->json(
            [
                'code' => 401, // code for authorization error
                'status' => 'erreur',
                'message' => "Oups! accès interdit !👺. Le token n'est plus valable ou une connexion est nécessaire"
            ]
        );
    }

   /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logIn(Request $request) {
        try {

            if(empty($request->email)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'erreur',
                        'message' => "L'adresse email est obligatoire"
                    ]
                );
            endif;

            if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'erreur',
                        'message' => "L'adresse e-mail n'est pas valide"
                    ]
                );
            endif;

            if(empty($request->password)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'erreur',
                        'message' => "Le mot de passe est obligatoire"
                    ]
                );
            endif;

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'erreur',
                        'message' => "Oups! accès interdit !👺, Email ou mot de passe introuvable"
                    ]
                );
            }

            $users = DB::table('users')->where('email', $request->email)->first();
            if (!$users || !password_verify($request->password, $users->password))
            {
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'erreur',
                        'message' => "Le mot de passe est incorrecte"
                    ]
                );
            }
            // return $users;

            $users_is_logged = DB::table('admin_account_models')
            ->join('users', 'admin_account_models.id', '=', 'users.user_id')
            ->join('role_models', 'admin_account_models.role_id', '=', 'role_models.id')
            ->select('users.email', 'users.status_connection','role_models.role', 'admin_account_models.*')
            ->where('admin_account_models.id', $users->user_id)->first();

            if($users_is_logged && $users_is_logged->status_account == 1):
                $online = DB::table('users')
                ->where('id', $users->id)
                ->update(['status_connection' => 1]);
                if($online):
                    return response()->json(
                        [
                            'code' => 100,
                            'token' => $token,
                            'users' => $users_is_logged,
                            'status' => "succès",
                            'token_type' => 'Bearer',
                            'expires_in' => Auth::factory()->getTTL(),
                            'message' => 'Vous êtes connecté 💚!'
                        ]
                    );
                else:
                    $offline = DB::table('users')
                    ->where('id', $users->id)
                    ->update(['status_connection' => 0]);
                    if($offline):
                        $online = DB::table('users')
                        ->where('id', $users->id)
                        ->update(['status_connection' => 1]);
                        if($online):
                            return response()->json(
                                [
                                    'code' => 100,
                                    'token' => $token,
                                    'users' => $users_is_logged,
                                    'status' => "succès",
                                    'token_type' => 'Bearer',
                                    'expires_in' => Auth::factory()->getTTL(),
                                    'message' => 'Vous êtes connecté 💚!'
                                ]
                            );
                        else:
                            return response()->json(
                                [
                                    'code' => 000,
                                    'status' => "Attention",
                                    'message' => 'La connexion n\'a pas pu être établir 👺! Merci de réessayer d\'avance '
                                ]
                            );
                        endif;
                    else:
                        return response()->json(
                            [
                                'code' => 000,
                                'status' => "Attention",
                                'message' => 'La connexion n\'a pas pu être établir 👺! Merci de réessayer d\'avance '
                            ]
                        );
                    endif;
                endif;
            else:
                return response()->json(
                    [
                        'code' => 000,
                        'status' => "Attention",
                        'message' => 'Vos n\'êtes pas un membre actif pour vous connecter à un espace sur le logiciel! 👺'
                    ]
                );
            endif;
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 302,
                    'message' => $e->getMessage()
                ]
            );
        }
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function updateUserPassword(Request $user)
    {
        try {
            if (empty($user->email)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'erreur',
                        'message' => "L'adresse e-mail est obligatoire."
                    ]
                );
            endif;

            if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'erreur',
                        'message' => "L'adresse e-mail n'est pas valide"
                    ]
                );
            endif;

            if (empty($user->password)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'erreur',
                        'message' => "Le mot de passe est obligatoire."
                    ]
                );
            endif;

            $is_admin_accounts = DB::table('admin_account_models')
                ->join('users', 'admin_account_models.id', '=', 'users.user_id')->where('users.email', $user->email)
                ->first();

            if ($is_admin_accounts == null ) {
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'erreur',
                        'message' => "Oups ! Votre compte n'existe pas ou est introuvable"
                    ]
                );
            } elseif ($is_admin_accounts != null ) {
                $reset_password = DB::table('admin_account_models')
                ->join('users', 'admin_account_models.id', '=', 'users.user_id')
                ->where('users.email', $user->email)
                ->update(['reset_password' => $user->password]);

                if($reset_password):
                    $password = password_hash($user->password, PASSWORD_BCRYPT);
                    $isUpdated = DB::table('users')->where('email', $user->email)->update([
                        'password' => $password
                    ]);
                    if ($isUpdated) {
                        $notifiction = "Votre mot de passe a été modifié avec succès." . " " . "#Adresse email: " . " " . $user->email . " " . "#Nouveau mot de passe: " . " " . $user->password;
                        // Mail::to($user->email)
                        //     ->send(new ForgetPasswordMailer($notifiction));
                        return response()->json(
                            [
                                'code' => 200,
                                'status' => 'succès',
                                'message' => "Ok ! Votre mot de passe a été modifié avec succès. Un mail vous a été envoyé sur votre adresse."
                            ]
                        );
                    }
                else
                        return response()->json(
                            [
                                'code' => 400,
                                'status' => 'Erreur',
                                'message' => "Oups ! Votre mot de passe n'a pas pu être chnagé."
                            ]
                        );
                endif;
            }

        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' => 302,
                    'message' => $e->getMessage()
                ]
            );
        }
    }

    public function logOut($id)
    {
        try {
            if(isset($id)){
                $logout = DB::table('users')->where('user_id', '=', $id)->update(['status_connection' => 0]);
                if($logout):
                    Session::flush();
                    Auth::logout();
                    return response()->json(
                        [
                            'code' => 100,
                            'status' => 'success',
                            'message' => "Merci ! Vous vous êtes déconnecté"
                        ]
                    );
                else:
                    return response()->json(
                        [
                            'code' => 000,
                            'status' => "Attention",
                            'message' => 'La déconnexion n\'a pas pu être effectuée 👺! Merci de réessayer d\'avance '
                        ]
                    );
                endif;
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
                    'status' => 'error',
                    'code' => 302,
                    'message' => $e->getMessage()
                ]
            );
        }
    }

    public function resetOldConnection($id)
    {
        try {
            DB::table('users')->where('user_id', $id)->update(['status_connection' => 0]);
            Session::flush();
            Auth::logout();
            return response()->json(
                [
                    'code' => 200,
                    'status' => 'success',
                    'message' => "Votre session a expiré ! Merci de vous connecter à nouveau."
                ]
            );
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' => 302,
                    'message' => $e->getMessage()
                ]
            );
        }
    }

    public function checkOldConnection(Request $request){
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['user_not_found'], 404);
                // return response()->json(
                //     [
                //         'status' => 'Connexion perdue',
                //         'code' => 401,
                //         "message" => "Votre session est expirée !",
                //     ]
                // );
            }
        } catch (JWTException $e) {
            return response()->json(['token_invalid'], $e);
        }
        return response()->json(
            [
                'status' => 'Connexion récente',
                'code' => 200,
                "users_data" => compact('user'),
            ]
        );
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
