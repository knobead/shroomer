<?php

declare(strict_types=1);

namespace App\Entity;

enum TreeGenusesEnum: string
{
    case GENUS_FRAXINUS = 'fraxinus';
    case GENUS_CASTANEA = 'castanea';
    case GENUS_QUERCUS = 'quercus';
    case GENUS_PINUS = 'pinus';
}
