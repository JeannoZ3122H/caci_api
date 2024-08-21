<?php

namespace App\Services;

class MessageService
{
    //
    public static function code100(){
        return "Opération réussie ! Merci.";
    }
    public static function code200(){
        return "La modification a été effectuée avec succès. Merci !";
    }
    public static function code300(){
        return "Erreur ! Élément introuvable.";
    }
    public static function code400(){
        return "Une erreur s'est produite lors du traitement de la requête. Veuillez réessayer !";
    }
    public static function code302($inp){
        return "Le champ ".$inp." est obligatoire. Merci !";
    }
}
