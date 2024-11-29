<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    /**
     * @dataProvider  dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Measurement();

        $measurement->setMinCelsius($celsius);
        $measurement->setMaxCelsius($celsius);

        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit(), "{$celsius}°C should be {$expectedFahrenheit}°F");
    }

    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['0.5', 32.9],
            ['10', 50],
            ['-10', 14],
            ['25', 77],
            ['37.5', 99.5],
            ['50', 122],
            ['-40', -40]
        ];
    }

}
