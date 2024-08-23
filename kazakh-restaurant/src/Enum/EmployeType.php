<?php
namespace App\Enum;

enum EmployeStatus: string
{
    case admin = 'admin';
    case chef = 'chef';
    case serveur = 'serveur';
    case autre = 'autre';
}

?>