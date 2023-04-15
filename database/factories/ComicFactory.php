<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Domain\Comic\ComicStatusCase\ComicStatusCaseEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comic>
 */
class ComicFactory extends Factory
{
    /**
     * @var class-string<\App\Models\Comic>
     */
    protected $model = Comic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $comicStatusCases = [
            ComicStatusCaseEnum::PUBLISHED->value,
            ComicStatusCaseEnum::DRAFT->value,
            ComicStatusCaseEnum::CLOSED->value,
        ];

        return [
            'key' => $this->faker->md5(),
            'name' => $this->faker->name(),
            'status' => current($this->faker->shuffle($comicStatusCases)),
        ];
    }
}
