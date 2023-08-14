<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Comic\ComicStatus;
use Tests\TestCase;

class ComicStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider provideEqualsSucceeded
     *
     * @param ComicStatus $comicStatus
     * @param ComicStatus $expected
     *
     * @return void
     */
    public function testEqualsSucceeded(ComicStatus $comicStatus, $expected)
    {
        $this->assertTrue($comicStatus->equals($expected));
    }

    /**
     * @dataProvider provideEqualsFailed
     *
     * @param ComicStatus $comicStatus
     * @param ComicStatus $expected
     *
     * @return void
     */
    public function testEqualsFailed(ComicStatus $comicStatus, $expected)
    {
        $this->assertFalse($comicStatus->equals($expected));
    }

    /**
     * @dataProvider provideDescriptionSucceeded
     *
     * @param ComicStatus $comicStatus
     * @param string $expected
     *
     * @return void
     */
    public function testDescriptionSucceeded(ComicStatus $comicStatus, string $expected)
    {
        $this->assertEquals($expected, $comicStatus->description());
    }

    /**
     * @dataProvider provideDescriptionFailed
     *
     * @param ComicStatus $comicStatus
     * @param string $expected
     *
     * @return void
     */
    public function testDescriptionFailed(ComicStatus $comicStatus, string $expected)
    {
        $this->assertNotEquals($expected, $comicStatus->description());
    }

    /**
     * @return array
     */
    public static function provideEqualsSucceeded(): array
    {
        return [
            [ComicStatus::PUBLISHED, ComicStatus::PUBLISHED],
            [ComicStatus::DRAFT, ComicStatus::DRAFT],
            [ComicStatus::CLOSED, ComicStatus::CLOSED],
        ];
    }

    /**
     * @return array
     */
    public static function provideEqualsFailed(): array
    {
        return [
            [ComicStatus::PUBLISHED, ComicStatus::DRAFT],
            [ComicStatus::PUBLISHED, ComicStatus::CLOSED],
            [ComicStatus::DRAFT, ComicStatus::PUBLISHED],
            [ComicStatus::DRAFT, ComicStatus::CLOSED],
            [ComicStatus::CLOSED, ComicStatus::PUBLISHED],
            [ComicStatus::CLOSED, ComicStatus::DRAFT],
        ];
    }

    /**
     * @return array
     */
    public static function provideDescriptionSucceeded(): array
    {
        return [
            [ComicStatus::PUBLISHED, '公開'],
            [ComicStatus::DRAFT, '下書き'],
            [ComicStatus::CLOSED, '非公開'],
        ];
    }

    /**
     * @return array
     */
    public static function provideDescriptionFailed(): array
    {
        return [
            [ComicStatus::PUBLISHED, 'dummy'],
            [ComicStatus::DRAFT, 'dummy'],
            [ComicStatus::CLOSED, 'dummy'],
        ];
    }
}
