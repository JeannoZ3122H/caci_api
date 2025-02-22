<?php

namespace Database\Seeders;

use App\Models\CompetenceModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Services\SlgGenrateService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompetenceModel::truncate();

        $data = [
            [
                'competence' => "Droit Immobilier",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Construction, Ingénierie",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Droit du bail",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Vente, Achat",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Responsabilité civile",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Assurance",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Energie et Ressources naturelles",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Arbitrage",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Droit Administratif",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Environnement",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Droits des sociétés/ Fusions et acquisitions",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'competence' => "Finance et Droit bancaire",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ]
        ];

        foreach($data as $item) {
            DB::table('competence_models')->insert($item);
        }
    }
}
