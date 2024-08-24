<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;

class UploadFileService
{
    /**
     * Create a new class instance.
     */
    public $path;
    public $filename;

    public function __construct()
    {
        //
    }

    public static function uploadFile($data, $file_name, $file_type)
    {
        if($data->hasFile($file_name)):
            $file = $data->file($file_name);
            $extension = $file->getClientOriginalExtension();

            if($file_type == "banner"):
                $filename ="banner_".time().'.'.$extension;
                if($filename):
                    $file->move('media/banner_img/',$filename);
                else:
                    return "error";
                endif;
                $path = "media/banner_img/";
            endif;

            if($file_type == "admin"):
                $filename ="admin_".time().'.'.$extension;
                if($filename):
                    $file->move('media/admin_img/',$filename);
                else:
                    return "error";
                endif;
                $path = "media/admin_img/";
            endif;

            if($file_type == "docs"):
                $filename ="docs_".time().'.'.$extension;
                if($filename):
                    $file->move('media/docs/',$filename);
                else:
                    return "error";
                endif;
                $path = "media/docs/";
            endif;


            if($file_type == "partner"):
                $filename ="partner_".time().'.'.$extension;
                if($filename):
                    $file->move('media/partner_img/',$filename);
                else:
                    return "error";
                endif;
                $path = "media/partner_img/";
            endif;

            if($file_type == "person"):
                $filename ="person_".time().'.'.$extension;
                if($filename):
                    $file->move('media/person_img/',$filename);
                else:
                    return "error";
                endif;
                $path = "media/person_img/";
            endif;

            if($file_type == "event_video"):
                $filename ="event_".time().'.'.$extension;
                if($filename):
                    $file->move('media/event_video/',$filename);
                else:
                    return "error";
                endif;
                $path = "media/event_video/";
            endif;

            if($file_type == "slide"):
                $filename ="slide_img_".time().'.'.$extension;
                if($filename):
                    $file->move('media/slide_img/',$filename);
                else:
                    return "error";
                endif;
                $path = "media/slide_img/";
            endif;

            $image_url = URL::to('').'/'.$path.$filename;
            return $image_url;
        else:
            return "file_not_found";
        endif;
    }

    public static function uploadFileMultiple($request)
    {
        foreach ($request->all() as $key => $value) {
            if ($value instanceof UploadedFile) {
                $extension = $value->getClientOriginalExtension();
                $filename ="event_".time().'.'.$extension;
                if($filename):
                    if ($value->move(public_path('media/event_img'), $filename)):
                        $path = 'media/event_img/' . $filename;
                        $image_url = URL::to('/') . '/' . $path;
                        $pathList[] = $image_url;
                    else:
                        return "error";
                    endif;
                else:
                    return "error";
                endif;
            }
        }
        return $pathList;
    }

    public static function uploadFileAny($request, $folder, $file_name, $input_name){
        if($request->hasFile($input_name)):
            $file = $request->file($input_name);
            $extension = $file->getClientOriginalExtension();
            $filename = $file_name.time().'.'.$extension;
            if($filename):
                $pulic_path = 'media/'.$folder.'/';
                $file->move(public_path($pulic_path) , $filename);
            else:
                return "error";
            endif;
            $path = $pulic_path;
            $image_url = URL::to('').'/'.$path.$filename;
            return $image_url;
        else:
            return "is_not_file";
        endif;
    }
}
