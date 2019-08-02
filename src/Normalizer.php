<?php
namespace TKuni\PhpNormalizer;


use TKuni\PhpNormalizer\Contracts\PipelineBuilderContract;
use TKuni\PhpNormalizer\Filters\CamelToSnakeFilter;
use TKuni\PhpNormalizer\Filters\EmptyToNullFilter;
use TKuni\PhpNormalizer\Filters\IntegerFilter;
use TKuni\PhpNormalizer\Filters\TrimFilter;
use TKuni\PhpNormalizer\Helper\DotChainOperator;

class Normalizer
{
    /**
     * @var array
     */
    private $rules;

    /**
     * @var array
     */
    private $pipelines = [];

    public function __construct(array $rules, PipelineBuilderContract $pipelineBuilder = null)
    {
        $this->rules = $rules;

        if ($pipelineBuilder === null) {
            $pipelineBuilder = $this->getDefaultPipelineBuilder();
        }

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

    private function getDefaultPipelineBuilder() {
        $classes = [
            TrimFilter::class,
            EmptyToNullFilter::class,
            CamelToSnakeFilter::class,
            IntegerFilter::class,
        ];

        $factory = new PipelineBuilder();

        foreach ($classes as $class) {
            $factory->registerFilter(new $class());
        }

        return $factory;
    }
}