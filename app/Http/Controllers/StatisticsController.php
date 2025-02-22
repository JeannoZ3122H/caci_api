<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Models\TeamsModel;
use App\Models\FolderUsModel;
use App\Models\StatisticsModel;
// use App\Models\TeamsModel;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{

    protected $middleware = [
        'auth:api', ['except' => ['store_web_app_statistics', 'data_all_statistics_web_app']]
    ];

    public function __construct()
    {
        $this->middleware;
    }

    public function data_all_statistics_web_app(){
        try {
            $last_vs_stats_2 = StatisticsModel::select('page', DB::raw('COUNT(*) as total'))
            ->groupBy('page')
            ->orderByDesc('total')
            ->get();
            $last_vs_stats = StatisticsModel::latest()->first();

            // return $last_vs_stats_2;
            if($last_vs_stats){
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 200,
                        'last_vs_stats' => $last_vs_stats,
                        'last_vs_stats_2' => $last_vs_stats_2,
                    ]
                );
            }else{
                return response()->json(
                    [
                        'status' => 'Erreur',
                        'code' => 400,
                        'last_vs_stats' => null,
                        'last_vs_stats_2' => null,
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

    public function store_web_app_statistics(Request $request){
        try {

            $count_personnel = TeamsModel::count();
            $count_folders = FolderUsModel::count();
            $count_visites = StatisticsModel::latest()->value('visites');

            $get_old_user_event = StatisticsModel::where('utilisateurs_uniques', '=', $request->utilisateur_unique)
            ->count();

            if($get_old_user_event > 0){
                return response()->json(
                    [
                        'code' => 000,
                        'status' => 'Information',
                        'message' => "Vous avez déjà effectué cette action."
                    ]
                );
            }

            $add = new StatisticsModel();

            $add->page = $request->page;
            $add->visites = $count_visites + 1;
            $add->utilisateurs_uniques = $request->utilisateur_unique;
            $add->temps_moyen = $request->temps_moyen;
            $add->date = $request->date;
            $add->navigateur = $request->navigateur;
            $add->dispositif = $request->dispositif;
            $add->source_traffic = $request->source_traffic;
            $add->folders = $count_folders;
            $add->members = $count_personnel;

            // return $add;
            if($add->save()){
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'message' => MessageService::code100()
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
}
