<?php
declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionResolver;

use App\Generator\Mycelium\Condition\AbstractCondition;

interface ConditionResolverInterface
{
    /**
     * @param AbstractCondition $abstractCondition
     *
     * @return bool
     */
    public function supports(AbstractCondition $abstractCondition): bool;

    /**
     * @param AbstractCondition $abstractCondition
     *
     * @return bool
     */
    public function resolve(AbstractCondition $abstractCondition): bool;
}
