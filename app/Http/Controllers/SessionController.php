<?php

namespace App\Http\Controllers;

use App\Models\SessionDelegationModel;
use App\Models\SessionEventModel;
use App\Models\SessionPartnersModel;
use App\Models\SessionTeamsModel;
use App\Services\StoreSessionService;
use App\Services\UpdateSessionService;
use App\Services\DestroySessionService;
use App\Services\SlgGenrateService;
use App\Models\SessionFooterMenuModel;
use App\Models\SessionFooterSubMenuModel;
use App\Models\SessionNavMenuModel;
use App\Models\SessionSubNavMenuModel;
use App\Models\SessionServiceModel;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Models\SessionPublicationModel;
class SessionController extends Controller
{

    protected $middleware = [
        'auth:api', // Reference the middleware group
    ];

    public function __construct()
    {
        $this->middleware;
    }

// 🐋🐋🐋🐋🐋 * * * * * * * * <= START EVENTS => * * * * * * * * 🐋🐋🐋🐋🐋 \\
    public function indexSevent(){
        try {
            $list = SessionEventModel::all();
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

    public function storeSevent(Request $request){
        $response = StoreSessionService::storeSevent($request);
        if($response){
            return response()->json($response);
        }
    }

    public function updateSevent(Request $request, $slg){
        if(isset($slg)){
            $response = UpdateSessionService::updateSevent($request, $slg);
            if($response){
                return response()->json($response);
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
    }

    public function deleteSevent($slg){
        if(!isset($slg)):
            return response()->json(
                [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ]
            );
        endif;
        $response = DestroySessionService::destroySevent($slg);
        if($response){
            return response()->json($response);
        }
    }
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END EVENTS => * * * * * * * * 🐋🐋🐋🐋🐋 \\


// 🐋🐋🐋🐋🐋 * * * * * * * * <= START PARTNERS => * * * * * * * * 🐋🐋🐋🐋🐋 \\
     public function indexSpartners(){
        try {
            $list = SessionPartnersModel::all();
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

    public function storeSpartners(Request $request){
        $response = StoreSessionService::storeSpartners($request);
        if($response){
            return response()->json($response);
        }
    }

    public function updateSpartners(Request $request, $slg){
        if(isset($slg)){
            $response = UpdateSessionService::updateSpartners($request, $slg);
            if($response){
                return response()->json($response);
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
    }

    public function deleteSpartners($slg){
        if(!isset($slg)):
            return response()->json(
                [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ]
            );
        endif;
        $response = DestroySessionService::destroySpartners($slg);
        if($response){
            return response()->json($response);
        }
    }
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END PARTNERS => * * * * * * * * 🐋🐋🐋🐋🐋 \\


// 🐋🐋🐋🐋🐋 * * * * * * * * <= START PUBLICATIONS => * * * * * * * * 🐋🐋🐋🐋🐋 \\
     public function indexSpublication(){
        try {
            $list = SessionPublicationModel::all();
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

    public function storeSpublication(Request $request){
        $response = StoreSessionService::storeSpublication($request);
        if($response){
            return response()->json($response);
        }
    }

    public function updateSpublication(Request $request, $slg){
        if(isset($slg)){
            $response = UpdateSessionService::updateSpublication($request, $slg);
            if($response){
                return response()->json($response);
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
    }

    public function deleteSpublication($slg){
        if(!isset($slg)):
            return response()->json(
                [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ]
            );
        endif;
        $response = DestroySessionService::destroySpublication($slg);
        if($response){
            return response()->json($response);
        }
    }
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END PUBLICATIONS => * * * * * * * * 🐋🐋🐋🐋🐋 \\


// 🐋🐋🐋🐋🐋 * * * * * * * * <= START TEAMS => * * * * * * * * 🐋🐋🐋🐋🐋 \\
     public function indexSteams(){
        try {
            $list = SessionTeamsModel::all();
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

    public function storeSteams(Request $request){
        $response = StoreSessionService::storeSteams($request);
        if($response){
            return response()->json($response);
        }
    }

    public function updateSteams(Request $request, $slg){
        if(isset($slg)){
            $response = UpdateSessionService::updateSteams($request, $slg);
            if($response){
                return response()->json($response);
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
    }

    public function deleteSteams($slg){
        if(!isset($slg)):
            return response()->json(
                [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ]
            );
        endif;
        $response = DestroySessionService::destroySteams($slg);
        if($response){
            return response()->json($response);
        }
    }
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END TEAMS => * * * * * * * * 🐋🐋🐋🐋🐋 \\


// 🐋🐋🐋🐋🐋 * * * * * * * * <= START SERVICE => * * * * * * * * 🐋🐋🐋🐋🐋 \\
     public function indexSservice(){
        try {
            $list = SessionServiceModel::all();
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

    public function storeSservice(Request $request){
        $response = StoreSessionService::storeSservice($request);
        if($response){
            return response()->json($response);
        }
    }

    public function updateSservice(Request $request, $slg){
        if(isset($slg)){
            $response = UpdateSessionService::updateSservice($request, $slg);
            if($response){
                return response()->json($response);
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
    }

    public function deleteSservice($slg){
        if(!isset($slg)):
            return response()->json(
                [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ]
            );
        endif;
        $response = DestroySessionService::destroySservice($slg);
        if($response){
            return response()->json($response);
        }
    }
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END SERVICE => * * * * * * * * 🐋🐋🐋🐋🐋 \\


// 🐋🐋🐋🐋🐋 * * * * * * * * <= START NAVBAR MENU => * * * * * * * * 🐋🐋🐋🐋🐋 \\
     public function indexSNavbarMenu(){
        try {
            $list = SessionNavMenuModel::all();
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

    public function storeSNavbarMenu(Request $request){
        $response = StoreSessionService::storeSNavbarMenu($request);
        if($response){
            return response()->json($response);
        }
    }

    public function updateSNavbarMenu(Request $request, $slg){
        if(isset($slg)){
            $response = UpdateSessionService::updateSNavbarMenu($request, $slg);
            if($response){
                return response()->json($response);
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
    }

    public function deleteSNavbarMenu($slg){
        if(!isset($slg)):
            return response()->json(
                [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ]
            );
        endif;
        $response = DestroySessionService::destroySNavbarMenu($slg);
        if($response){
            return response()->json($response);
        }
    }
    public function change_session_navbar_menu_item_order(Request $request, $slg)
    {
        try {
            if (!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = SessionNavMenuModel::where('slug', '=', $slg)
                ->update(['item_order' => $request->item_order]);
            if ($resp) {
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => "L'opération a été effectuée, l'élément a été placé en position " . strval($request->item_order) . " dans la liste"
                    ]
                );
            } else {
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
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END  NAVBAR MENU => * * * * * * * * 🐋🐋🐋🐋🐋 \\


// 🐋🐋🐋🐋🐋 * * * * * * * * <= START NAVBAR SUBMENU => * * * * * * * * 🐋🐋🐋🐋🐋 \\
     public function indexSNavbarSubMenu(){
        try {
            $list = SessionSubNavMenuModel::Join('session_nav_menu_models', 'session_sub_nav_menu_models.nav_item_id', 'session_nav_menu_models.id')
            ->select('session_nav_menu_models.*', 'session_sub_nav_menu_models.*')
            ->get();

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

    public function storeSNavbarSubMenu(Request $request){
        $response = StoreSessionService::storeSNavbarSubMenu($request);
        if($response){
            return response()->json($response);
        }
    }

    public function updateSNavbarSubMenu(Request $request, $slg){
        if(isset($slg)){
            $response = UpdateSessionService::updateSNavbarSubMenu($request, $slg);
            if($response){
                return response()->json($response);
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
    }

    public function deleteSNavbarSubMenu($slg){
        if(!isset($slg)):
            return response()->json(
                [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ]
            );
        endif;
        $response = DestroySessionService::destroySNavbarSubMenu($slg);
        if($response){
            return response()->json($response);
        }
    }
    public function change_session_sub_navbar_item_order(Request $request, $slg)
    {
        try {
            if (!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = SessionSubNavMenuModel::where('slug', '=', $slg)
                ->update(['item_order' => $request->item_order]);
            if ($resp) {
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => "L'opération a été effectuée, l'élément a été placé en position " . strval($request->item_order) . " dans la liste"
                    ]
                );
            } else {
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
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END NAVBAR SUBMENU => * * * * * * * * 🐋🐋🐋🐋🐋 \\


// 🐋🐋🐋🐋🐋 * * * * * * * * <= START FOOTER MENU => * * * * * * * * 🐋🐋🐋🐋🐋 \\
     public function indexSFooterMenu(){
        try {
            $list = SessionFooterMenuModel::all();
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

    public function storeSFooterMenu(Request $request){
        $response = StoreSessionService::storeSFooterMenu($request);
        if($response){
            return response()->json($response);
        }
    }

    public function updateSFooterMenu(Request $request, $slg){
        if(isset($slg)){
            $response = UpdateSessionService::updateSFooterMenu($request, $slg);
            if($response){
                return response()->json($response);
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
    }

    public function deleteSFooterMenu($slg){
        if(!isset($slg)):
            return response()->json(
                [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ]
            );
        endif;
        $response = DestroySessionService::destroySFooterMenu($slg);
        if($response){
            return response()->json($response);
        }
    }
    public function change_session_footer_menu_item_order(Request $request, $slg)
    {
        try {
            if (!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = SessionFooterMenuModel::where('slug', '=', $slg)
                ->update(['item_order' => $request->item_order]);
            if ($resp) {
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => "L'opération a été effectuée, l'élément a été placé en position " . strval($request->item_order) . " dans la liste"
                    ]
                );
            } else {
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
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END  NAVBAR MENU => * * * * * * * * 🐋🐋🐋🐋🐋 \\


// 🐋🐋🐋🐋🐋 * * * * * * * * <= START NAVBAR SUBMENU => * * * * * * * * 🐋🐋🐋🐋🐋 \\
     public function indexSFooterSubMenu(){
        try {
            $list = SessionFooterSubMenuModel::Join('session_footer_menu_models', 'session_footer_sub_menu_models.nav_footer_item_id', 'session_footer_menu_models.id')
            ->select('session_footer_menu_models.*', 'session_footer_sub_menu_models.*')
            ->get()->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'nav_footer_item' => $menu->nav_footer_item,
                    'nav_list_footer_item' => $menu->nav_list_footer_item,
                    'nav_list_footer_item_content' => json_decode($menu->nav_list_footer_item_content),
                    'item_order' => $menu->item_order,
                    'perimetre' => $menu->perimetre,
                    'nav_footer_item_id' => $menu->nav_footer_item_id,
                    'nav_list_footer_item_code' => $menu->nav_list_footer_item_code,
                    'nav_list_footer_item_icon' => $menu->nav_list_footer_item_icon,
                    'nav_list_footer_item_type_content' => $menu->nav_list_footer_item_type_content,
                    'slug' => $menu->slug,
                    'created_at' => $menu->created_at,
                    'updated_at' => $menu->updated_at,
                ];
            });

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

    public function storeSFooterSubMenu(Request $request){
        $response = StoreSessionService::storeSFooterSubMenu($request);
        if($response){
            return response()->json($response);
        }
    }

    public function updateSFooterSubMenu(Request $request, $slg){
        if(isset($slg)){
            $response = UpdateSessionService::updateSFooterSubMenu($request, $slg);
            if($response){
                return response()->json($response);
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
    }

    public function deleteSFooterSubMenu($slg){
        if(!isset($slg)):
            return response()->json(
                [
                    'code' => 300,
                    'status' => 'Erreur',
                    'message' => MessageService::code300()
                ]
            );
        endif;
        $response = DestroySessionService::destroySFooterSubMenu($slg);
        if($response){
            return response()->json($response);
        }
    }
    public function change_session_footer_sub_menu_item_order(Request $request, $slg)
    {
        try {
            if (!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = SessionFooterSubMenuModel::where('slug', '=', $slg)
                ->update(['item_order' => $request->item_order]);
            if ($resp) {
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => "L'opération a été effectuée, l'élément a été placé en position " . strval($request->item_order) . " dans la liste"
                    ]
                );
            } else {
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
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END NAVBAR SUBMENU => * * * * * * * * 🐋🐋🐋🐋🐋 \\


// 🐋🐋🐋🐋🐋 * * * * * * * * <= START PUBLICATIONS => * * * * * * * * 🐋🐋🐋🐋🐋 \\
public function indexSdelegation(){
    try {
        $list = SessionDelegationModel::all();
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

public function storeSdelegation(Request $request){
    $response = StoreSessionService::storeSdelegation($request);
    if($response){
        return response()->json($response);
    }
}

public function updateSdelegation(Request $request, $slg){
    if(isset($slg)){
        $response = UpdateSessionService::updateSdelegation($request, $slg);
        if($response){
            return response()->json($response);
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
}

public function deleteSdelegation($slg){
    if(!isset($slg)):
        return response()->json(
            [
                'code' => 300,
                'status' => 'Erreur',
                'message' => MessageService::code300()
            ]
        );
    endif;
    $response = DestroySessionService::destroySdelegation($slg);
    if($response){
        return response()->json($response);
    }
}
// 🐋🐋🐋🐋🐋 * * * * * * * * <= END PUBLICATIONS => * * * * * * * * 🐋🐋🐋🐋🐋 \\

}
