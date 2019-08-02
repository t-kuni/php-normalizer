<?php


namespace TKuni\PhpNormalizer;


use TKuni\PhpNormalizer\Contracts\FilterProviderContract;
use TKuni\PhpNormalizer\Contracts\PipelineBuilderContract;
use TKuni\PhpNormalizer\Contracts\PipelineBuilderFactoryContract;
use TKuni\PhpNormalizer\Filters\CamelToSnakeFilter;
use TKuni\PhpNormalizer\Filters\EmptyToNullFilter;
use TKuni\PhpNormalizer\Filters\IntegerFilter;
use TKuni\PhpNormalizer\Filters\TrimFilter;

class PipelineBuilderFactory implements PipelineBuilderFactoryContract
{
    public function make(): PipelineBuilderContract
    {
        $classes = $this->getFilterClasses();

        $factory = new PipelineBuilder();

        foreach ($classes as $class) {
            $factory->registerFilter(new $class());
        }

        return $factory;
    }

    private function getFilterClasses() {
        $provider = Container::container()->get(FilterProviderContract::class);
        var_dump($provider->provideFilters());
        return $provider->provideFilters();
    }
}