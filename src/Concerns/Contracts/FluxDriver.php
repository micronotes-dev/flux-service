<?php

namespace Micronotes\Flux\Concerns\Contracts;

use Micronotes\Flux\Concerns\AbstractFluxRepository;

interface FluxDriver
{
    public static function name(): string;

    public function getRepository(?RowConverter $converter = null): AbstractFluxRepository;

    public function getProvider(): string;

    /**
     * @return array<int, string>
     */
    public function getConverters(): array;

    public function getConverterForMorphedModel(string $alias): string;

    public function getModelForConverter(string $converter): ?string;
}
