<?php


namespace TKuni\PhpNormalizer\Contracts;


interface PipelineBuilderFactoryContract
{
    public function make() : PipelineBuilderContract;
}