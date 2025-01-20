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
        switch ($genus) {
            case self::GENUS_FRAXINUS:
                return [
                    MyceliumGenusEnum::GENUS_MORCHELLA,
                ];
            case self::GENUS_CASTANEA:
                return [
                    MyceliumGenusEnum::GENUS_BOLETUS,
                    MyceliumGenusEnum::GENUS_AMANITA
                ];
            case self::GENUS_PINUS:
                return [
                    MyceliumGenusEnum::GENUS_XEROCOMUS,
                    MyceliumGenusEnum::GENUS_CANTHARELLUS,
                    MyceliumGenusEnum::GENUS_PLEUROTUS,
                ];
            case self::GENUS_QUERCUS:
                return [
                    MyceliumGenusEnum::GENUS_BOLETUS,
                    MyceliumGenusEnum::GENUS_AMANITA,
                ];
        }
    }
}
