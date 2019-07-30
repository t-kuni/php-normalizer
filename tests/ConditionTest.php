<?php

namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;
use TKuni\PhpNormalizer\Condition as Cond;

class ConditionTest extends TestCase
{

    /**
     * @test
     */
    public function canNormalizeMultiple()
    {
        $actual = Cond::isEmpty()->toNull()->apply(' 20 ');
        $expect = ' 20 ';
        $this->assertEquals($expect, $actual);

        $actual = Cond::isNotEmpty()->toInt()->apply(' 20 ');
        $expect = 20;
        $this->assertEquals($expect, $actual);
    }
}