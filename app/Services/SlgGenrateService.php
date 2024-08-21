<?php

namespace App\Services;

class SlgGenrateService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function slgGenerate(){
        $lenght= 100;
        $keys = substr(str_shuffle(
            str_repeat($x = '1234567890', ceil($lenght / strlen($x)))
        ), 3, $lenght);
        return $keys;
    }
    public static function passwordGenerate(){
        $lenght= 8;
        $keys = substr(str_shuffle(
            str_repeat($x = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', ceil($lenght / strlen($x)))
        ), 3, $lenght);
        return $keys;
    }
}
