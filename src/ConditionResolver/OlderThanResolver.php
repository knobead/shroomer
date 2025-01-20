<?php

declare(strict_types=1);

namespace App\ConditionResolver;

use App\Condition\AbstractCondition;
use App\Condition\OlderThan;
use App\Entity\DatableInterface;
use App\Exception\InvalidContextException;

class OlderThanResolver implements ConditionResolverInterface
{
    /**
     * @param AbstractCondition $abstractCondition
     *
     * @return bool
     */
    public function supports(AbstractCondition $abstractCondition): bool
    {
        return $abstractCondition instanceof OlderThan;
    }

    /**
     * @param OlderThan $abstractCondition
     * @param array     $context
     *
     * @return bool
     * @throws InvalidContextException
     * @inheritDoc
     */
    public function resolve(AbstractCondition $abstractCondition, array $context = []): bool
    {
        if (!array_key_exists($key = 'datable', $context)) {
            throw new InvalidContextException($key, DatableInterface::class);
        }

        $datable = $context[$key];

        if(!$datable instanceof DatableInterface) {
            throw new InvalidContextException($key, DatableInterface::class);
        }

        return $datable->getAge() > $abstractCondition->getAge();
    }
}
