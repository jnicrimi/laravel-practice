<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comic extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'key',
        'name',
        'status',
    ];

    /**
     * @param Builder $query
     * @param string $key
     *
     * @return Builder
     */
    public function scopeKey(Builder $query, string $key): Builder
    {
        if (strlen($key)) {
            $query->where('key', $key);
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string $name
     *
     * @return Builder
     */
    public function scopeLikeName(Builder $query, string $name): Builder
    {
        if (strlen($name)) {
            $query->where('name', 'like', "%{$name}%");
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param array $status
     *
     * @return Builder
     */
    public function scopeStatus(Builder $query, array $status): Builder
    {
        if (count($status) > 0) {
            $query->whereIn('status', $status);
        }

        return $query;
    }
}
