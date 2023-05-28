<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\AbstractEntity;
use Packages\Domain\EntityInterface;

class Comic extends AbstractEntity implements EntityInterface
{
    /**
     * @var ComicId|null
     */
    private $id;

    /**
     * @var ComicKey
     */
    private $key;

    /**
     * @var ComicName
     */
    private $name;

    /**
     * @var ComicStatus
     */
    private $status;

    /**
     * Constructor
     *
     * @param ComicId|null $id
     * @param ComicKey $key
     * @param ComicName $name
     * @param ComicStatus $status
     */
    public function __construct(
        ?ComicId $id,
        ComicKey $key,
        ComicName $name,
        ComicStatus $status
    ) {
        $this->id = $id;
        $this->key = $key;
        $this->name = $name;
        $this->status = $status;
    }

    /**
     * @return ComicId|null
     */
    public function getId(): ?ComicId
    {
        return $this->id;
    }

    /**
     * @return ComicKey
     */
    public function getKey(): ComicKey
    {
        return $this->key;
    }

    /**
     * @return ComicName
     */
    public function getName(): ComicName
    {
        return $this->name;
    }

    /**
     * @return ComicStatus
     */
    public function getStatus(): ComicStatus
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId() ? $this->getId()->getValue() : null,
            'key' => $this->getKey()->getValue(),
            'name' => $this->getName()->getValue(),
            'status' => $this->getStatus()->value,
        ];
    }
}
