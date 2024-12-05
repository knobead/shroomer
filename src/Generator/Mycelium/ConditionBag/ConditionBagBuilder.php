<?php
declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionBag;

use App\Generator\Mycelium\Condition\AbstractCondition;
use RuntimeException;

class ConditionBagBuilder
{
    private iterable $conditionBagBuilders;

    public function __construct(iterable $conditionBagBuilders)
{
    $this->conditionBagBuilders = $conditionBagBuilders;
}

    /**
     * @param string $type
     *
     * @return AbstractCondition[]
     */
    public function build(string $type): array
    {
        foreach ($this->conditionBagBuilders as $conditionBagBuilder) {
            if (!$conditionBagBuilder instanceof ConditionBagBuilderInterface) {
                throw new RuntimeException(sprintf(
                    '%s expects a collection of %s',
                    self::class,
                    ConditionBagBuilderInterface::class
                ));
            }

            if ($conditionBagBuilder->supports($type)) {
                return $conditionBagBuilder->builds();
            }
        }

        throw new RuntimeException(sprintf(
            'no %s found to support %s',
            ConditionBagBuilderInterface::class,
            $type
        ));
    }
}
