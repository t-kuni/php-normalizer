<?php
namespace TKuni\PhpNormalizer;


use TKuni\PhpNormalizer\Filters\CamelToSnakeFilter;
use TKuni\PhpNormalizer\Filters\EmptyToNullFilter;
use TKuni\PhpNormalizer\Filters\IntegerFilter;
use TKuni\PhpNormalizer\Filters\TrimFilter;

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

    public function __construct(array $rules)
    {
        $factory = $this->initFactory();

        $this->rules = $rules;

        foreach ($rules as $propName => $filterNames) {
            $this->pipelines[$propName] = $factory->make($filterNames);
        }
    }

    public function normalize(array $in) {
        $out = [];

        foreach ($this->pipelines as $propName => $pipeline) {
            if ($this->isArray($propName)) {
                $propNames = explode('.*.', $propName);
                $currOut = &$out;
                $currIn = &$in;
                for ($i = 0; $i < count($propNames); $i++) {
                    $propName = $propNames[$i];
                    if (!isset($currOut[$propName])) {
                        $currOut[$propName] = null;
                    }
                    $currOut = &$currOut[$propName];

                    $currIn = &$currIn[$propName];

                    if ($i > 0) {
                        foreach ($currin)
                    }
                }
                foreach ($propNames as $i => $propName) {
                    if (!isset($currOut[$propName])) {
                        $currOut[$propName] = null;
                    }
                    $currOut = &$currOut[$propName];

                    $currIns = &$currIn[$propName];
                }

                foreach ($currIns as $currIn) {

                }
                $currOut = $pipeline->apply($currIn ?? null);
            } else {
                $out[$propName] = $pipeline->apply($in[$propName] ?? null);
            }
        }

        return $out;
    }

    private function isArray($propName) {
        return strpos($propName, '.*.') !== false;
    }

    private function initFactory() {
        $classes = [
            TrimFilter::class,
            EmptyToNullFilter::class,
            CamelToSnakeFilter::class,
            IntegerFilter::class,
        ];

        $factory = new PipelineFactory();

        foreach ($classes as $class) {
            $factory->registerFilter(new $class());
        }

        return $factory;
    }
}