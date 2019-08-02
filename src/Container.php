<?php


namespace TKuni\PhpNormalizer;

use League\Container\Container as BaseContainer;
use TKuni\PhpNormalizer\Contracts\FilterProviderContract;
use TKuni\PhpNormalizer\Contracts\PipelineBuilderFactoryContract;

class Container
{
    /**
     * @var null|BaseContainer
     */
    private static $container = null;

    public static function container() : BaseContainer {
        if (self::$container === null) {
            self::$container = self::makeContainer();
        }

        return self::$container;
    }

    private static function makeContainer() {
        $c = new BaseContainer();

        $c->add(PipelineBuilderFactoryContract::class, PipelineBuilderFactory::class);
        $c->add(FilterProviderContract::class, DefaultFilterProvider::class, true);

        return $c;
    }
}