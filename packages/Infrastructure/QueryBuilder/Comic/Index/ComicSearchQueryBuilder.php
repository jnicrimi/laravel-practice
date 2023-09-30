<?php

declare(strict_types=1);

namespace Packages\Infrastructure\QueryBuilder\Comic\Index;

use App\Models\Comic;
use Illuminate\Database\Eloquent\Builder;
use Packages\Infrastructure\QueryBuilder\AbstractQueryBuilder;
use Packages\Infrastructure\QueryBuilder\QueryBuilderInterface;

class ComicSearchQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var string|null
     */
    private $key;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var array|null
     */
    private $status;

    /**
     * @param string|null $key
     *
     * @return self
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string|null $name
     *
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param array|null $status
     *
     * @return self
     */
    public function setStatus(?array $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Builder
     */
    public function build(): Builder
    {
        $query = Comic::query();
        if ($this->key !== null) {
            $query->key($this->key);
        }
        if ($this->name !== null) {
            $query->likeName($this->name);
        }
        if ($this->status !== null) {
            $query->status($this->status);
        }

        return $query;
    }
}
