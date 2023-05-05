<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Lang;
use Packages\Domain\Comic\ComicStatus;
use Tests\TestCase;

class ComicStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testEqualsSucceeded()
    {
        $comicStatus = ComicStatus::PUBLISHED;
        $this->assertTrue($comicStatus->equals(ComicStatus::PUBLISHED));
    }

    /**
     * @return void
     */
    public function testEqualsFailed()
    {
        $comicStatus = ComicStatus::PUBLISHED;
        $this->assertFalse($comicStatus->equals(ComicStatus::DRAFT));
    }

    /**
     * @return void
     */
    public function testDescriptionSucceeded()
    {
        $comicStatus = ComicStatus::PUBLISHED;
        $expected = Lang::get('company/status.description.published');
        $this->assertEquals($expected, $comicStatus->description());
    }

    /**
     * @return void
     */
    public function testDescriptionFailed()
    {
        $comicStatus = ComicStatus::PUBLISHED;
        $this->assertNotEquals('dummy', $comicStatus->description());
    }
}
