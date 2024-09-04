<?php
namespace App\Enum;

enum ReservationType : string
{
    case sur_place = 'sur_place';
    case emporter = 'emporter';
    case livraison = 'livraison';
    case privatisation = 'privatisation';
}

?>