<?php

declare(strict_types=1);

namespace Packages\Infrastructure\EntityFactory;

use Packages\Domain\EntityInterface;

interface EntityFactoryInterface
{
    /**
     * @param array $attributes
     * @param EntityInterface|null $entity
     *
     * @return EntityInterface
     */
    public function create(array $attributes, ?EntityInterface $entity = null): EntityInterface;
}
