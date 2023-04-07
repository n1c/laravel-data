<?php

namespace Spatie\LaravelData\Support\NameMapping;

use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Support\Lazy\CachedLazy;

class DataClassNameMapping
{
    /*
    * @param array<string, string> $mapped
    * @param array<string, class-string<\Spatie\LaravelData\Support\DataClass>> $mappedDataObjects
    */
    public function __construct(
        readonly array $mapped,
        readonly array $mappedDataObjects,
    ) {
    }

    public function getOriginal(string $mapped): ?string
    {
        return $this->mapped[$mapped] ?? null;
    }

    public function resolveNextMapping(
        DataConfig $dataConfig,
        string $mappedOrOriginal
    ): ?self {
        $dataClass = $this->mappedDataObjects[$mappedOrOriginal] ?? null;

        if ($dataClass === null) {
            return null;
        }

        $outputNameMapping = $dataConfig->getDataClass($dataClass)->outputNameMapping;

        return $outputNameMapping->resolve();
    }
}
