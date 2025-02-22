<?php

namespace Database\Seeders;

use App\Models\ProfessionModel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Services\SlgGenrateService;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfessionModel::truncate();

        $data = [
            [
                'profession' => "Avocat",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Juriste",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Notaire",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Assistant juridique",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Clerc de notaire",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Secrétaire juridique",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Conseiller juridique",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Expert en arbitrage",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Chargé de recouvrement",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Responsable de la conformité (Compliance officer)",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Fiscaliste",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Médiateur",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Gestionnaire de patrimoine",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Avocat en droit des affaires",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Consultant juridique",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Expert juridique",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Expert",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Auditeur juridique",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Spécialiste en droit international",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Enseignant en droit",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Expert-comptable légal",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'profession' => "Formateur",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
        ];

        foreach($data as $item) {
            DB::table('profession_models')->insert($item);
        }
    }
}
