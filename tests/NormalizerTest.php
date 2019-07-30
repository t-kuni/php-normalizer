<?php

namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;

class NormalizerTest extends TestCase
{

    /**
     * @test
     */
    public function canNormalizeMultiple()
    {
        $n = new Normalizer([
            'name'   => ['trim', 'empty_to_null'],
            'age'    => ['trim', 'empty_to_null', 'integer'],
            'gender' => ['trim', 'empty_to_null', 'integer'],
        ]);

        $actual = $n->normalize([
            'name' => '    hoge  fuga ',
            'age'  => ' 20 ',
        ]);

        $expect = [
            'name'   => 'hoge  fuga',
            'age'    => 20,
            'gender' => null,
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function throwExceptionIfUnknownFilter()
    {

        $n = new Normalizer([
            'age' => ['trim', 'unknown', 'integer'],
        ]);

        $actual = $n->normalize([
            'name' => '    hoge  fuga ',
            'age'  => ' 20 ',
        ]);
    }
}