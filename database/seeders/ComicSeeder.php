<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Comic;
use Illuminate\Database\Seeder;

class ComicSeeder extends Seeder
{
    /**
     * @var int
     */
    public const CREATE_COUNT = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comic::factory()
            ->count(self::CREATE_COUNT)
            ->create();
    }
}
