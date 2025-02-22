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
class DestroySessionService
{
    public static function destroySevent($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionEventModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function destroySpartners($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionPartnersModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function destroySpublication($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionPublicationModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function destroySteams($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionTeamsModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function destroySservice($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionServiceModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function destroySNavbarMenu($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionNavMenuModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function destroySNavbarSubMenu($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionSubNavMenuModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function destroySFooterMenu($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionFooterMenuModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function destroySFooterSubMenu($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionFooterSubMenuModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function destroySdelegation($slg){
        try {
            if(!isset($slg)):
                return [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ];
            endif;
            $resp = SessionDelegationModel::where('slug', '=', $slg)->delete();
            if($resp){
                return [
                    'code' => 100,
                    'status' => 'Succès',
                    'message' => MessageService::code100()
                ];
            }else{
                return [
                    'code' => 400,
                    'status' => 'Erreur',
                    'message' => MessageService::code400()
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'Erreur',
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }
}
