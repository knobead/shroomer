<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Generator\Message\GenerateTreeMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GenerateTreeHandler
{
    /**
     * @param GenerateTreeMessage $generateTreeMessage
     *
     * @return void
     */
    public function __invoke(GenerateTreeMessage $generateTreeMessage)
    {

    }
}
