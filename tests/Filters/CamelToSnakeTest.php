<?php
namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;
use TKuni\PhpNormalizer\Filters\CamelToSnakeFilter;

class CamelToSnakeTest extends TestCase {

    /**
     * @test
     */
    public function canConvertToSnake() {
        $input   = 'FooBarClass';

        $actual = (new CamelToSnakeFilter())->apply($input);

        $expect = 'foo_bar_class';

        $this->assertEquals($expect, $actual);
    }
}