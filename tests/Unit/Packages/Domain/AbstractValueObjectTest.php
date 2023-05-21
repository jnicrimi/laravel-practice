<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\AbstractValueObject;
use Tests\TestCase;

class AbstractValueObjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    public const DEFAULT_VALUE = 'default';

    /**
     * @return void
     */
    public function testGetValue()
    {
        $valueObject = $this->createValueObject();
        $actual = $valueObject->getValue();
        $expected = self::DEFAULT_VALUE;
        $this->assertSame($actual, $expected);
    }

    /**
     * @dataProvider provideEquals
     *
     * @param mixed $expected
     * @param mixed $value
     *
     * @return void
     */
    public function testEquals($expected, $value)
    {
        $valueObjectA = $this->createValueObject();
        $valueObjectB = $this->createValueObject($value);
        $actual = $valueObjectA->equals($valueObjectB);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function provideEquals(): array
    {
        return [
            [true, null],
            [false, 'dummy'],
        ];
    }

    /**
     * @param mixed $value
     *
     * @return AbstractValueObject
     */
    private function createValueObject($value = null): AbstractValueObject
    {
        if ($value === null) {
            $value = self::DEFAULT_VALUE;
        }

        return new class ($value) extends AbstractValueObject {
            protected function validate(): bool
            {
                return true;
            }
        };
    }
}
