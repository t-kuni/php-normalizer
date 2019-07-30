<?php
namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;

class NormalizerTest extends TestCase {

    /**
     * @test
     */
    public function canFilterSingleValue() {
        $input   = '   hoge  fuga ';
        $filters = ['trim', 'empty_to_null'];

        $actual = Normalizer::normalize($input, $filters);

        $expect = 'hoge  fuga';

        $this->assertEquals($expect, $actual);
    }
}