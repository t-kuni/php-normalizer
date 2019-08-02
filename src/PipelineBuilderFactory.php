<?php


namespace TKuni\PhpNormalizer;


use TKuni\PhpNormalizer\Contracts\FilterProviderContract;
use TKuni\PhpNormalizer\Contracts\PipelineBuilderContract;
use TKuni\PhpNormalizer\Contracts\PipelineBuilderFactoryContract;

class PipelineBuilderFactory implements PipelineBuilderFactoryContract
{
    public function make(): PipelineBuilderContract
    {
        $filters = $this->getFilters();

        $factory = new PipelineBuilder();

        foreach ($filters as $name => $filter) {
            $factory->registerFilter($filter, $name);
        }

        return $factory;
    }

    private function getFilters(): array
    {
        $provider = Container::container()->get(FilterProviderContract::class);
        return $provider->provideFilters();
    }
}