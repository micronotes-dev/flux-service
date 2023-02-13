<?php

namespace Micronotes\Flux\Concerns\Contracts;

use Micronotes\Flux\Concerns\AbstractFluxRepository;

interface FluxDriver
{
    public function getRepository(): AbstractFluxRepository;

    public function getProvider(): string;

    /**
     * @return array<int, string>
     */
    public function getConverters(): array;

    public function getConverterForMorphedModel(string $alias): string;
}
