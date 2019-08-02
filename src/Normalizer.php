<?php
namespace TKuni\PhpNormalizer;


use TKuni\PhpNormalizer\Contracts\NormalizerContract;
use TKuni\PhpNormalizer\Contracts\PipelineBuilderContract;
use TKuni\PhpNormalizer\Contracts\PipelineBuilderFactoryContract;
use TKuni\PhpNormalizer\Filters\CamelToSnakeFilter;
use TKuni\PhpNormalizer\Filters\EmptyToNullFilter;
use TKuni\PhpNormalizer\Filters\IntegerFilter;
use TKuni\PhpNormalizer\Filters\TrimFilter;
use TKuni\PhpNormalizer\Helper\DotChainOperator;

class Normalizer implements NormalizerContract
{
    /**
     * @var array
     */
    private $rules;

    /**
     * @var array
     */
    private $pipelines = [];

    public function __construct(array $rules)
    {
        $this->rules = $rules;

        $pipelineBuilder = $this->getPipelineBuilder();

        foreach ($rules as $propName => $filterNames) {
            $this->pipelines[$propName] = $pipelineBuilder->make($filterNames);
        }
    }

    public function normalize(array $in) {
        $out = $in;

        foreach ($this->pipelines as $propName => $pipeline) {
            $out = DotChainOperator::update($out, $propName, function ($in) use ($pipeline) {
                return $pipeline->apply($in);
            });
        }

        return $out;
    }

    private function getPipelineBuilder() {
        $pipelineBuilderFactory = Container::container()->get(PipelineBuilderFactoryContract::class);
        return $pipelineBuilderFactory->make();
    }
}