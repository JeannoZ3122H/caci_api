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


class StoreSessionService
{

    public static function storeSevent($request){
        try {
            if(empty($request->title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('Titre')
                ];
            endif;
            if(empty($request->sup_title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('titre supérieur')
                ];
            endif;
            $add = new SessionEventModel();
            $add->sup_title = $request->sup_title;
            $add->title = $request->title;
            $add->description = $request->description;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function storeSpartners($request){
        try {
            if(empty($request->title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('Titre')
                ];
            endif;
            if(empty($request->sup_title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('titre supérieur')
                ];
            endif;
            $add = new SessionPartnersModel();
            $add->sup_title = $request->sup_title;
            $add->title = $request->title;
            $add->description = $request->description;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function storeSpublication($request){
        try {
            if(empty($request->description)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('description')
                ];
            endif;
            if(empty($request->sup_title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('titre supérieur')
                ];
            endif;

            $add = new SessionPublicationModel();
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
                    $add->banner = $image_url;
                endif;
            endif;
            $add->sup_title = $request->sup_title;
            $add->icon = $request->icon;
            $add->description = $request->description;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function storeSteams($request){
        try {
            if(empty($request->title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('Titre')
                ];
            endif;
            if(empty($request->sup_title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('titre supérieur')
                ];
            endif;
            $add = new SessionTeamsModel();
            $add->sup_title = $request->sup_title;
            $add->title = $request->title;
            $add->description = $request->description;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function storeSdelegation($request){
        try {
            if(empty($request->title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('Titre')
                ];
            endif;
            if(empty($request->sup_title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('titre supérieur')
                ];
            endif;
            $add = new SessionDelegationModel();
            $add->sup_title = $request->sup_title;
            $add->title = $request->title;
            $add->description = $request->description;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function storeSservice($request){
        try {
            if(empty($request->title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('Titre')
                ];
            endif;
            if(empty($request->sup_title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('titre supérieur')
                ];
            endif;
            $add = new SessionServiceModel();
            $add->sup_title = $request->sup_title;
            $add->title = $request->title;
            $add->description = $request->description;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function storeSNavbarMenu($request){
        try {
            if(empty($request->title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('Titre')
                ];
            endif;
            if(empty($request->nav_item)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('menu')
                ];
            endif;

            $last = SessionNavMenuModel::all()->last();
            $add = new SessionNavMenuModel();
            $add->author_id = $request->author_id;
            $add->title = $request->title;
            $add->nav_item = $request->nav_item;
            $add->route = $request->route;
            $add->item_order = $last->item_order + 1;
            $add->nav_item_code = SlgGenrateService::generateSessionCodeGenerate($last->nav_item_code);
            $add->status_nav_list = $request->status_nav_list;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function storeSNavbarSubMenu($request){
        try {
            if(empty($request->title)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('Titre')
                ];
            endif;
            if(empty($request->nav_list_item)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('sous-menu')
                ];
            endif;

            $last = SessionSubNavMenuModel::all()->last();
            $add = new SessionSubNavMenuModel();
            $add->author_id = $request->author_id;
            $add->nav_item_id = $request->nav_item_id;
            $add->title = $request->title;
            $add->item_order = $last->item_order + 1;
            $add->nav_list_item_code = SlgGenrateService::generateSessionCodeGenerate($last->nav_list_item_code);
            $add->nav_list_item = $request->nav_list_item;
            $add->route = $request->route;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function storeSFooterMenu($request){
        try {
            if(empty($request->nav_footer_item)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('menu')
                ];
            endif;
            if(empty($request->perimetre)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('périmètre')
                ];
            endif;

            $last = SessionFooterMenuModel::all()->last();
            $add = new SessionFooterMenuModel();
            $add->author_id = $request->author_id;
            $add->nav_footer_item = $request->nav_footer_item;
            $add->item_order = $last->item_order + 1;
            $add->nav_footer_item_code = SlgGenrateService::generateSessionCodeGenerate($last->nav_footer_item_code);
            $add->perimetre = $request->perimetre;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function storeSFooterSubMenu($request){
        try {
            if(empty($request->nav_list_footer_item_type_content)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('type de contenu')
                ];
            endif;
            if(empty($request->nav_footer_item_id)):
                return [
                    'code' => 302,
                    'status' => 'Erreur',
                    'message' => MessageService::code302('menu')
                ];
            endif;

            $last = SessionFooterSubMenuModel::all()->last();
            $add = new SessionFooterSubMenuModel();
            $add->author_id = $request->author_id;
            $add->nav_footer_item_id = $request->nav_footer_item_id;
            $add->nav_list_footer_item = $request->nav_list_footer_item;
            $add->item_order = $last->item_order + 1;
            $add->nav_list_footer_item_code = SlgGenrateService::generateSessionCodeGenerate($last->nav_list_footer_item_code);
            $add->nav_list_footer_item_icon = $request->nav_list_footer_item_icon;
            $add->nav_list_footer_item_type_content = $request->nav_list_footer_item_type_content;
            $add->nav_list_footer_item_content = $request->nav_list_footer_item_content;
            $add->slug = SlgGenrateService::slgGenerate();
            if($add->save()):
                return [
                    'status' => 'success',
                    'code' => 100,
                    'message' => MessageService::code100()
                ];
            else:
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => MessageService::code100()
                ];
            endif;
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }
}
