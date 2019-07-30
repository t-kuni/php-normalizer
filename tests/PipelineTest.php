<?php
namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;
use TKuni\PhpNormalizer\Filters\EmptyToNullFilter;
use TKuni\PhpNormalizer\Filters\TrimFilter;

class PipelineTest extends TestCase {

    /**
     * @test
     */
    public function canTrim() {
        $input   = '   hoge  fuga ';

        $actual = (new Pipeline([new EmptyToNullFilter(), new TrimFilter()]))
            ->apply($input);

        $expect = 'hoge  fuga';

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canEmptyToNull() {
        $input   = '';

        $actual = (new Pipeline([new EmptyToNullFilter(), new TrimFilter()]))
            ->apply($input);

        $expect = null;

        $this->assertEquals($expect, $actual);
    }
}