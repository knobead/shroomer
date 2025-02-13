<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Model\Cost;
use Symfony\Component\Serializer\Annotation\Groups;

#[
    ApiResource(normalizationContext: ['groups' => ['read']], mercure: false),
    GetCollection()
]
enum TreeGenusesEnum: string implements PayableInterface
{
    case GENUS_FRAXINUS = 'fraxinus';
    case GENUS_CASTANEA = 'castanea';
    case GENUS_QUERCUS = 'quercus';
    case GENUS_PINUS = 'pinus';

    #[Groups('read')]
    public function getName(): string
    {
        return $this->value;
    }

    #[Groups(['read'])]
    public function getCost(): Cost
    {
        return match($this) {
          self::GENUS_QUERCUS => new Cost(350,100,75),
          self::GENUS_CASTANEA => new Cost(300,50,50),
          self::GENUS_FRAXINUS => new Cost(750,200,200),
          self::GENUS_PINUS => new Cost(250,0,0),
        };
    }

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
            ]
        };
    }
}
