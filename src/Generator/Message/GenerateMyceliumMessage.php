<?php

declare(strict_types=1);

namespace App\Generator\Message;

class GenerateMyceliumMessage
{
    private int $myceliumId;

    /**
     * @param int $myceliumId
     */
    public function __construct(int $myceliumId)
    {
        $this->myceliumId = $myceliumId;
    }

    /**
     * @return int
     */
    public function getMyceliumId(): int
    {
        return $this->myceliumId;
    }
}
