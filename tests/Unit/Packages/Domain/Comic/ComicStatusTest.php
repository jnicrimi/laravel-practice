<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Comic\ComicStatus;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ComicStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var int
     */
    public const CASE_COUNT = 3;

    public function testCases(): void
    {
        $this->assertCount(self::CASE_COUNT, ComicStatus::cases());
    }

    #[DataProvider('provideEqualsSuccess')]
    public function testEqualsSuccess(ComicStatus $comicStatus, ComicStatus $expected): void
    {
        $this->assertTrue($comicStatus->equals($expected));
    }

    #[DataProvider('provideEqualsFailure')]
    public function testEqualsFailure(ComicStatus $comicStatus, ComicStatus $expected): void
    {
        $this->assertFalse($comicStatus->equals($expected));
    }

    #[DataProvider('provideDescriptionSuccess')]
    public function testDescriptionSuccess(ComicStatus $comicStatus, string $expected): void
    {
        $this->assertEquals($expected, $comicStatus->description());
    }

    #[DataProvider('provideDescriptionFailure')]
    public function testDescriptionFailure(ComicStatus $comicStatus, string $expected): void
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
