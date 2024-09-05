<?php

namespace App\Enum;

enum Role: string
{
    case EMPLOYE = 'ROLE_EMPLOYE';
    case LIVREUR = 'ROLE_LIVREUR';
    case ADMIN = 'ROLE_ADMIN';
}

?>