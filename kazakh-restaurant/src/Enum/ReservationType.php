<?php
namespace App\Enum;

enum ReservationType : string
{
    case SUR_PLACE = 'sur place';
    case EMPORTER = 'emporter';
    case LIVRAISON = 'livraison';
    case PRIVATISATION = 'privatisation';
}

?>