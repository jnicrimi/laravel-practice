<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Carbon\Carbon;
use Packages\Domain\AbstractEntity;
use Packages\Domain\EntityInterface;

class Comic extends AbstractEntity implements EntityInterface
{
    /**
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
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null
    ) {
    }

    /**
     * @throws ComicIdIsNotSetException
     *
     * @return ComicId
     */
    public function getId(): ComicId
    {
        if ($this->id === null) {
            throw new ComicIdIsNotSetException();
        }

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
     * @param ComicKey $key
     *
     * @return void
     */
    public function changeKey(ComicKey $key): void
    {
        $this->key = $key;
    }

    /**
     * @param ComicName $name
     *
     * @return void
     */
    public function changeName(ComicName $name): void
    {
        $this->name = $name;
    }

    /**
     * @param ComicStatus $status
     *
     * @return void
     */
    public function changeStatus(ComicStatus $status): void
    {
        $this->status = $status;
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
            'id' => $this->getId()->getValue(),
            'key' => $this->getKey()->getValue(),
            'name' => $this->getName()->getValue(),
            'status' => $this->getStatus()->value,
            'created_at' => $this->getCreatedAt()?->format(self::DATE_FORMAT),
            'updated_at' => $this->getUpdatedAt()?->format(self::DATE_FORMAT),
        ];
    }
}
