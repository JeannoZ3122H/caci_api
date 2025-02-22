<?php

namespace App\Services;

use App\Models\SessionDelegationModel;
use App\Models\SessionEventModel;
use App\Models\SessionFooterMenuModel;
use App\Models\SessionFooterSubMenuModel;
use App\Models\SessionNavMenuModel;
use App\Models\SessionSubNavMenuModel;
use App\Models\SessionPartnersModel;
use App\Models\SessionServiceModel;
use App\Models\SessionTeamsModel;
use App\Models\SessionPublicationModel;
use Illuminate\Support\Facades\URL;
class UpdateSessionService
{
    public static function updateSevent($request, $slg){
        try {
            if(isset($slg)){
                $data = SessionEventModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->sup_title = $request->sup_title;
                    $data->title = $request->title;
                    $data->description = $request->description;
                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function updateSpartners($request, $slg){
        try {
            if(isset($slg)){
                $data = SessionPartnersModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->sup_title = $request->sup_title;
                    $data->title = $request->title;
                    $data->description = $request->description;
                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function updateSdelegation($request, $slg){
        try {
            if(isset($slg)){
                $data = SessionDelegationModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->sup_title = $request->sup_title;
                    $data->title = $request->title;
                    $data->description = $request->description;
                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function updateSpublication($request, $slg){
        try {
            if(isset($slg)){
                $data = SessionPublicationModel::Where('slug', '=', $slg)->first();
                if($data){
                    if(!empty($request->banner)):
                        if($request->hasFile('banner')):
                            $file = $request->file('banner');
                            $extension = $file->getClientOriginalExtension();
                            $filename = 'banner_publication'.time().'.'.$extension;
                            if($filename):
                                $pulic_path = 'media/banner_img/';
                                $file->move(public_path($pulic_path) , $filename);
                            else:
                                return "error";
                            endif;
                            $path = $pulic_path;
                            $image_url = URL::to('').'/'.$path.$filename;
                            $data->banner = $image_url;
                        endif;
                    endif;

                    $data->sup_title = $request->sup_title;
                    $data->icon = $request->icon;
                    $data->description = $request->description;
                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function updateSteams($request, $slg){
        try {
            if(isset($slg)){
                $data = SessionTeamsModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->sup_title = $request->sup_title;
                    $data->title = $request->title;
                    $data->description = $request->description;
                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function updateSservice($request, $slg){
        try {
            if(isset($slg)){
                $data = SessionServiceModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->sup_title = $request->sup_title;
                    $data->title = $request->title;
                    $data->description = $request->description;
                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function updateSNavbarMenu($request, $slg){
        try {
            if(isset($slg)){
                $data = SessionNavMenuModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->author_id = $request->author_id;
                    $data->title = $request->title;
                    $data->nav_item = $request->nav_item;
                    $data->route = $request->route;
                    $data->nav_item_code = $request->nav_item_code;
                    $data->status_nav_list = $request->status_nav_list;
                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function updateSNavbarSubMenu($request, $slg){
        try {
            if(isset($slg)){
                $instance = new self();
                $data = SessionSubNavMenuModel::Where('slug', '=', $slg)->first();
                if($data){

                    $data->author_id = $request->author_id;
                    $data->nav_item_id = $request->nav_item_id;
                    $data->title = $request->title;
                    $data->nav_list_item = $request->nav_list_item;
                    // $data->route = $instance->dynamicRoute($request->route, $request->nav_list_item);

                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function updateSFooterMenu($request, $slg){
        try {
            if(isset($slg)){
                $data = SessionFooterMenuModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->author_id = $request->author_id;
                    $data->nav_footer_item = $request->nav_footer_item;
                    $data->perimetre = $request->perimetre;
                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function updateSFooterSubMenu($request, $slg){
        try {
            if(isset($slg)){
                $data = SessionFooterSubMenuModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->author_id = $request->author_id;
                    $data->nav_footer_item_id = $request->nav_footer_item_id;
                    $data->nav_list_footer_item = $request->nav_list_footer_item;
                    $data->nav_list_footer_item_icon = $request->nav_list_footer_item_icon;
                    $data->nav_list_footer_item_type_content = $request->nav_list_footer_item_type_content;
                    $data->nav_list_footer_item_content = $request->nav_list_footer_item_content;
                    if($data->save()){
                        return [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code200(),
                        ];
                    };
                }else{
                    return [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ];
                }
            }else{
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'erreur',
                'code' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function dynamicRoute($route, $route_name){
        // Remplace les guillemets simples par des guillemets doubles pour un format JSON valide
        $route = str_replace("'", '"', $route);

        // Décoder la chaîne en tableau PHP
        $array = json_decode($route, true);

        // Vérifier si le décodage a réussi et si le tableau n'est pas vide
        if (is_array($array) && !empty($array)) {
            // Modifier dynamiquement le dernier élément du tableau
            $str = str_replace("-", " ", $route_name);
            $array[count($array) - 1] = strtolower($str);

            return json_encode($array);
        }
    }
}
