<?php

declare(strict_types=1);

namespace App\Generator\Message;

class GenerateSporocarpMessage
{
    private int $sporocarpId;

    /**
     * @param int $treeId
     */
    public function __construct(int $treeId)
    {
        $this->sporocarpId = $treeId;
    }

    /**
     * @return int
     */
    public function getSporocarpId(): int
    {
        return $this->sporocarpId;
    }
}
