<?php

declare(strict_types=1);

namespace App\Entity;

enum TreeGenusesEnum: string
{
    case GENUS_FRAXINUS = 'fraxinus';
    case GENUS_CASTANEA = 'castanea';
    case GENUS_QUERCUS = 'quercus';
    case GENUS_PINUS = 'pinus';

    /**
     * it returns available mycelium type by tree genuses
     *
     * @param TreeGenusesEnum $genus
     *
     * @return array
     */
    public static function getMyceliums(TreeGenusesEnum $genus): array
    {
        return match ($genus) {
            self::GENUS_FRAXINUS => [
                MyceliumGenusEnum::GENUS_MORCHELLA,
            ],
            self::GENUS_CASTANEA => [
                MyceliumGenusEnum::GENUS_BOLETUS,
                MyceliumGenusEnum::GENUS_AMANITA
            ],
            self::GENUS_PINUS => [
                MyceliumGenusEnum::GENUS_XEROCOMUS,
                MyceliumGenusEnum::GENUS_CANTHARELLUS,
                MyceliumGenusEnum::GENUS_PLEUROTUS,
            ],
            self::GENUS_QUERCUS => [
                MyceliumGenusEnum::GENUS_BOLETUS,
                MyceliumGenusEnum::GENUS_AMANITA,
            ],
            default => [],
        };
    }
}
