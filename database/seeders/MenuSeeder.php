<?php

namespace Database\Seeders;

use App\Models\SessionSubNavMenuModel;
use App\Models\SessionNavMenuModel;
use App\Models\SessionFooterMenuModel;
use App\Models\SessionFooterSubMenuModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Services\SlgGenrateService;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        SessionSubNavMenuModel::truncate();
        SessionNavMenuModel::truncate();
        SessionFooterMenuModel::truncate();
        SessionFooterSubMenuModel::truncate();

        $data_menu = [
            [
                'item_order' => 1,
                "title" => "ACCUEIL",
                'nav_item' => "Accueil",
                'route' => "['/']",
                'nav_item_code' => "MENU-001",
                'status_nav_list' => false,
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'item_order' => 2,
                "title" => "À PROPOS",
                'nav_item' => "À propos",
                'route' => null,
                'nav_item_code' => "MENU-002",
                'status_nav_list' => true,
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'item_order' => 3,
                "title" => "SERVICES | ",
                'nav_item' => "Services",
                'route' => null,
                'nav_item_code' => "MENU-003",
                'status_nav_list' => true,
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'item_order' => 4,
                "title" => "INFOS PRATIQUES | ",
                'nav_item' => "Infos pratiques",
                'route' => null,
                'nav_item_code' => "MENU-004",
                'status_nav_list' => true,
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'item_order' => 5,
                "title" => "ACTUALITÉS | ",
                'nav_item' => "Actualités",
                'route' => null,
                'nav_item_code' => "MENU-005",
                'status_nav_list' => true,
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'item_order' => 6,
                "title" => "RESSOURCES | ",
                'nav_item' => "Ressources",
                'route' => null,
                'nav_item_code' => "MENU-006",
                'status_nav_list' => true,
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
        ];


        $data_sub_menu = [
            [
                'nav_item_id' => 2,
                'item_order' => 1,
                "title" => "HISTORIQUE",
                'nav_list_item_code' => "SUBMENU-001",
                'nav_list_item' => "Historique",
                'route' => "['/web.a-propos-de-la-caci.historique']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 2,
                'item_order' => 2,
                "title" => "MOT DU PRÉSIDENT",
                'nav_list_item_code' => "SUBMENU-002",
                'nav_list_item' => "Mot du Président",
                'route' => "['/web.a-propos-de-la-caci.mot-du-president']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 2,
                'item_order' => 3,
                "title" => "MISSIONS",
                'nav_list_item_code' => "SUBMENU-003",
                'nav_list_item' => "Missions",
                'route' => "['/web.a-propos-de-la-caci.missions']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 2,
                'item_order' => 4,
                "title" => "ORGANISATIONS",
                'nav_list_item_code' => "SUBMENU-004",
                'nav_list_item' => "Organisation",
                'route' => "['/web.a-propos-de-la-caci.organisation']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 2,
                'item_order' => 5,
                "title" => "DÉLÉGATIONS",
                'nav_list_item_code' => "SUBMENU-005",
                'nav_list_item' => "Délégations",
                'route' => "['/web.a-propos-de-la-caci.delegations']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 2,
                'item_order' => 6,
                "title" => "PARTENAIRES",
                'nav_list_item_code' => "SUBMENU-006",
                'nav_list_item' => "Partenaires",
                'route' => "['/web.a-propos-de-la-caci.partenaires']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],

            [
                'nav_item_id' => 4,
                'item_order' => 7,
                "title" => "SUIVIE DE NOTRE DOSSIER EN LIGNE",
                'nav_list_item_code' => "SUBMENU-007",
                'nav_list_item' => "Suivi de votre dossier en ligne",
                'route' => "['/web.information-pratiques', 'MENU-004', 'suivi-de-votre-dossier-en-ligne']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 4,
                'item_order' => 8,
                "title" => "CALCUL DE FRAIS DE PROCÉDURE",
                'nav_list_item_code' => "SUBMENU-008",
                'nav_list_item' => "Calcul des frais de procédure",
                'route' => "['/web.information-pratiques', 'MENU-004', 'calcul-des-frais-de-procédure']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 4,
                'item_order' => 9,
                "title" => "CONSULTATION",
                'nav_list_item_code' => "SUBMENU-009",
                'nav_list_item' => "Consultation du répertoire des arbitres, médiateurs et expert",
                'route' => "['/web.information-pratiques', 'MENU-004', 'consultation-du-répertoire-des-arbitres,-médiateurs-et-expert']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 4,
                'item_order' => 10,
                "title" => "FAQ",
                'nav_list_item_code' => "SUBMENU-010",
                'nav_list_item' => "Foire aux questions",
                'route' => "['/web.information-pratiques', 'MENU-004', 'foire-aux-questions']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],

            [
                'nav_item_id' => 5,
                'item_order' => 11,
                "title" => "ACTIVITÉS",
                'nav_list_item_code' => "SUBMENU-011",
                'nav_list_item' => "Activités",
                'route' => "['/web.actualites.activites']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 5,
                'item_order' => 12,
                "title" => "AGENDA",
                'nav_list_item_code' => "SUBMENU-012",
                'nav_list_item' => "Agenda",
                'route' => "['/web.actualites.agenda']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],

            [
                'nav_item_id' => 6,
                'item_order' => 13,
                "title" => "PUBLICATIONS",
                'nav_list_item_code' => "SUBMENU-013",
                'nav_list_item' => "Publications",
                'route' => "['/web.ressources.publications']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_item_id' => 6,
                'item_order' => 14,
                "title" => "LIENS UTILES",
                'nav_list_item_code' => "SUBMENU-014",
                'nav_list_item' => "Liens utiles",
                'route' => "['/web.ressources.lien-utiles']",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
        ];


        $data_footer_menu = [
            [
                'item_order' => 1,
                'nav_footer_item_code' => "FMENU-001",
                'nav_footer_item' => "Suivez-nous",
                'perimetre' => "col-lg-2",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'item_order' => 2,
                'nav_footer_item_code' => "FMENU-002",
                'nav_footer_item' => "Direction générale",
                'perimetre' => "col-lg-3",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
        ];


        $data_footer_sub_menu = [
            [
                'nav_footer_item_id' => 2,
                'item_order' => 1,
                'nav_list_footer_item_code' => "FSUBMENU-001",
                'nav_list_footer_item_icon' => "<i class=\"mr-1 display-8 icofont icofont-phone me-2\"></i>",
                'nav_list_footer_item' => "Tel",
                'nav_list_footer_item_type_content' => "tel",
                'nav_list_footer_item_content' => "[{phone: \"(+225) 20 30 97 29\"},{phone: \"(+225) 20 30 97 49\"}]",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_footer_item_id' => 2,
                'item_order' => 2,
                'nav_list_footer_item_code' => "FSUBMENU-002",
                'nav_list_footer_item_icon' => "<i class=\"mr-3 display-8 icofont icofont-email me-2\"></i>",
                'nav_list_footer_item' => "Email",
                'nav_list_footer_item_type_content' => "mailto",
                'nav_list_footer_item_content' => "[{email: \"caci@cci.ci\"}]",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_footer_item_id' => 2,
                'item_order' => 2,
                'nav_list_footer_item_code' => "FSUBMENU-002",
                'nav_list_footer_item_icon' => "<i class=\"mr-3 display-8 icofont icofont-map-pins me-2\"></i>",
                'nav_list_footer_item' => "Adresse",
                'nav_list_footer_item_type_content' => "address",
                'nav_list_footer_item_content' => "01 BP 1399 Abidjan 01 – RCI",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
            [
                'nav_footer_item_id' => 2,
                'item_order' => 2,
                'nav_list_footer_item_code' => "FSUBMENU-002",
                'nav_list_footer_item_icon' => "<i class=\"mr-3 display-8 icofont icofont-wall-clock me-2\"></i>",
                'nav_list_footer_item' => "Horaire",
                'nav_list_footer_item_type_content' => "hours",
                'nav_list_footer_item_content' => "Lundi au Vendredi de 08h00 à 12h30, 13h30 à 17h00",
                'slug' => SlgGenrateService::slgGenerate(),
                'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                'updated_at' => date("Y-m-d H:i:s", strtotime(now()))
            ],
        ];

        foreach($data_sub_menu as $item) {
            DB::table('session_sub_nav_menu_models')->insert($item);
        }

        foreach($data_menu as $item) {
            DB::table('session_nav_menu_models')->insert($item);
        }

        foreach($data_footer_menu as $item) {
            DB::table('session_footer_menu_models')->insert($item);
        }

        foreach($data_footer_sub_menu as $item) {
            DB::table('session_footer_sub_menu_models')->insert($item);
        }
    }
}
