<?php

namespace TKuni\PhpNormalizer\Contracts;

interface FilterProviderContract
{
    public function provideFilters();

    public function addFilter(string $name, $filter);

    public function addFilters(array $filters);
}