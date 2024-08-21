<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\TeamsModel;
use App\Models\BannerModel;
use Illuminate\Http\Request;
use App\Models\PartnersModel;
use App\Models\SlideUneModel;
use App\Models\TestimonialsModel;

class FrontendController extends Controller
{
    //

    public function get_frontent_data(){
        try {
            $data_une = SlideUneModel::all();
            $data_event = EventModel::OrderByDesc('id')->get();
            $data_banner = BannerModel::OrderByDesc('id')->get();
            $data_personal = TeamsModel::OrderByDesc('id')->get();
            $data_partners = PartnersModel::OrderByDesc('id')->get();
            $data_testimonial = TestimonialsModel::OrderByDesc('id')->get();
            if(
                $data_event != null ||
                $data_banner != null ||
                $data_personal != null ||
                $data_partners != null ||
                $data_testimonial != null ||
                $data_une != null
            ){
                return response()->json(
                    [
                        'data_une' => $data_une,
                        'data_event' => $data_event,
                        'data_banner' => $data_banner,
                        'data_personal' => $data_personal,
                        'data_partners' => $data_partners,
                        'data_testimonial' => $data_testimonial,
                    ]
                );
            }
            else{
                return response()->json(
                    [
                        'data_event' => [],
                        'data_banner' => [],
                        'data_personal' => [],
                        'data_partners' => [],
                        'data_testimonial' => [],
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
