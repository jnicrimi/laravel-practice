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
     * @return void
     */
    public function testGetValue()
    {
        $valueObject = $this->createValueObject();
        $actual = $valueObject->getValue();
        $expected = 'A';
        $this->assertSame($actual, $expected);
    }

    /**
     * @return AbstractValueObject
     */
    private function createValueObject(): AbstractValueObject
    {
        $value = 'A';

        return new class ($value) extends AbstractValueObject {
            protected function validate(): bool
            {
                return true;
            }
        };
    }
}
