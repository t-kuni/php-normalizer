<?php
namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;
use TKuni\PhpNormalizer\Filters\EmptyToNullFilter;
use TKuni\PhpNormalizer\Filters\TrimFilter;

class PipelineFactoryTest extends TestCase {

    /**
     * @test
     */
    public function canMakePipeline() {
        $input   = '   hoge  fuga ';

        $factory = (new PipelineFactory())
            ->registerFilter(new EmptyToNullFilter())
            ->registerFilter(new TrimFilter());

        $pipeline = $factory->make(['empty_to_null', 'trim']);

        $actual = $pipeline->apply($input);

        $expect = 'hoge  fuga';

        $this->assertEquals($expect, $actual);
    }
}