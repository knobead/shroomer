<?php
declare(strict_types=1);

namespace App\Entity;

enum TreeTypeEnum: string
{
    case TYPE_LEAFY = 'leafy';
    case TYPE_CONIFEROUS = 'coniferous';
}
