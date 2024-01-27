<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Carbon\Carbon;
use Packages\Domain\AbstractEntity;
use Packages\Domain\EntityInterface;

class Comic extends AbstractEntity implements EntityInterface
{
    /**
     * Constructor
     *
     * @param ComicId|null $id
     * @param ComicKey $key
     * @param ComicName $name
     * @param ComicStatus $status
     * @param Carbon|null $createdAt
     * @param Carbon|null $updatedAt
     */
    public function __construct(
        private ?ComicId $id,
        private ComicKey $key,
        private ComicName $name,
        private ComicStatus $status,
        private ?Carbon $createdAt,
        private ?Carbon $updatedAt
    ) {
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
     * @return Carbon|null
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @return bool
     */
    public function canDelete(): bool
    {
        return $this->getStatus()->equals(ComicStatus::CLOSED);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId()?->getValue(),
            'key' => $this->getKey()->getValue(),
            'name' => $this->getName()->getValue(),
            'status' => $this->getStatus()->value,
            'created_at' => $this->getCreatedAt()?->format(self::DATE_FORMAT),
            'updated_at' => $this->getUpdatedAt()?->format(self::DATE_FORMAT),
        ];
    }
}
