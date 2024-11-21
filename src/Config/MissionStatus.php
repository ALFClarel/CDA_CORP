<?php

namespace App\Config;

enum Status: string
{
    case PENDING = 'En Attente';
    case IN_PROGRESS = 'En Cours';
    case COMPLETED = 'Terminée';
    case FAILED = 'Échouée';
}
?>