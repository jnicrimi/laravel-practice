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
     * @var int
     */
    public const CASE_COUNT = 3;

    /**
     * @return void
     */
    public function testCases(): void
    {
        $this->assertCount(self::CASE_COUNT, ComicStatus::cases());
    }

    /**
     * @dataProvider provideEqualsSuccess
     *
     * @param ComicStatus $comicStatus
     * @param ComicStatus $expected
     *
     * @return void
     */
    public function testEqualsSuccess(ComicStatus $comicStatus, $expected)
    {
        $this->assertTrue($comicStatus->equals($expected));
    }

    /**
     * @dataProvider provideEqualsFailure
     *
     * @param ComicStatus $comicStatus
     * @param ComicStatus $expected
     *
     * @return void
     */
    public function testEqualsFailure(ComicStatus $comicStatus, $expected)
    {
        $this->assertFalse($comicStatus->equals($expected));
    }

    /**
     * @dataProvider provideDescriptionSuccess
     *
     * @param ComicStatus $comicStatus
     * @param string $expected
     *
     * @return void
     */
    public function testDescriptionSuccess(ComicStatus $comicStatus, string $expected)
    {
        $this->assertEquals($expected, $comicStatus->description());
    }

    /**
     * @dataProvider provideDescriptionFailure
     *
     * @param ComicStatus $comicStatus
     * @param string $expected
     *
     * @return void
     */
    public function testDescriptionFailure(ComicStatus $comicStatus, string $expected)
    {
        $this->assertNotEquals($expected, $comicStatus->description());
    }

    /**
     * @return array
     */
    public static function provideEqualsSuccess(): array
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
    public static function provideEqualsFailure(): array
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
    public static function provideDescriptionSuccess(): array
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
    public static function provideDescriptionFailure(): array
    {
        return [
            [ComicStatus::PUBLISHED, 'dummy'],
            [ComicStatus::DRAFT, 'dummy'],
            [ComicStatus::CLOSED, 'dummy'],
        ];
    }
}
