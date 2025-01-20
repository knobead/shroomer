<?php

declare(strict_types=1);

namespace App\Generator\Message;

class GenerateTreeMessage
{
    private int $treeId;

    /**
     * @param int $treeId
     */
    public function __construct(int $treeId)
    {
        $this->treeId = $treeId;
    }

    /**
     * @return int
     */
    public function getTreeId(): int
    {
        return $this->treeId;
    }
}
