<?php

namespace App\Services;

use App\Models\messageModel;
use Carbon\Carbon;

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
    public static function codeGenerate(){
        $lenght= 3;
        $keys = substr(str_shuffle(
            str_repeat($x = '1234567890', ceil($lenght / strlen($x)))
        ), 3, $lenght);
        return "SERV-".$keys;
    }
    public static function orgCodeGenerate(){
        $lenght= 3;
        $keys = substr(str_shuffle(
            str_repeat($x = '123456789', ceil($lenght / strlen($x)))
        ), 3, $lenght);
        return "ORG-".$keys;
    }
    public static function generateCodeRef(){
        $lenght= 5;
        $keys = substr(str_shuffle(
            str_repeat($x = '1234567890QWERTYUIOPASDFGHJKLZXCVBNM', ceil($lenght / strlen($x)))
        ), 3, $lenght);
        return "CODE-".$keys;
    }
    public static function matriculeGenerate(){
        $lenght= 5;
        $keys = substr(str_shuffle(
            str_repeat($x = '1234567890QWERTYUIOPASDFGHJKLZXCVBNM', ceil($lenght / strlen($x)))
        ), 3, $lenght);
        return "MAT-".$keys;
    }
    public static function saisirCodeGenerate($type){
        $nbre = messageModel::count();
        $currentYear = Carbon::now()->year;
        $value = $nbre+1 > 9?$nbre+1:'00'.strval($nbre+1);
        return "CACI/".$value."-".$type."/".strval($currentYear);
    }

    public static function generateSessionCodeGenerate($last_code){
        $instance = new self();
        return $instance->incrementString($last_code);
    }

    // increment string value by text
    private function incrementString($string) {
        // Extraire la partie numérique avec une expression régulière
        if (preg_match('/(.*?)(\d+)$/', $string, $matches)) {
            $prefix = $matches[1]; // Partie avant le numéro, par exemple "FMENU-"
            $number = $matches[2]; // Partie numérique, par exemple "002"
            // Incrémenter le nombre et conserver le format avec des zéros
            $incrementedNumber = str_pad((int)$number + 1, strlen($number), '0', STR_PAD_LEFT);
            // Reformuler la chaîne avec le nouveau nombre
            return $prefix . $incrementedNumber;
        }
        return $string; // Retourner la chaîne d'origine si aucun numéro n'est trouvé
    }
}
