<?php

declare(strict_types=1);

namespace Packages\Infrastructure\EntityFactory;

use Packages\Domain\EntityInterface;

abstract class AbstractEntityFactory
{
    /**
     * @param array $attributes
     * @param EntityInterface|null $entity
     *
     * @return EntityInterface
     */
    abstract public function create(array $attributes, ?EntityInterface $entity = null): EntityInterface;
}
