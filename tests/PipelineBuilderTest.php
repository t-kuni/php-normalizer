<?php
namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;
use TKuni\PhpNormalizer\Filters\EmptyToNullFilter;
use TKuni\PhpNormalizer\Filters\TrimFilter;

class PipelineBuilderTest extends TestCase
{

    /**
     * @test
     */
    public function canMakePipeline() {
        $input   = '   hoge  fuga ';

        $builder = (new PipelineBuilder())
            ->registerFilter(new EmptyToNullFilter())
            ->registerFilter(new TrimFilter());

        $pipeline = $builder->make(['empty_to_null', 'trim']);

        $actual = $pipeline->apply($input);

        $expect = 'hoge  fuga';

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canSpecifyFilterName()
    {
        $input = '   hoge  fuga ';

        $builder = (new PipelineBuilder())
            ->registerFilter(new EmptyToNullFilter(), 'e2n')
            ->registerFilter(new TrimFilter(), 't');

        $pipeline = $builder->make(['e2n', 't']);

        $actual = $pipeline->apply($input);

        $expect = 'hoge  fuga';

        $this->assertEquals($expect, $actual);
    }
}