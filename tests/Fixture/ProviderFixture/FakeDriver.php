<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture;

use Micronotes\Flux\Concerns\AbstractFluxRepository;
use Micronotes\Flux\Concerns\Contracts\FluxDriver;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\Exceptions\FluxException;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels\Foo;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowDataConverters\FooConverter;

class FakeDriver implements FluxDriver
{
    public function getRepository(?RowConverter $converter = null): AbstractFluxRepository
    {
        return match (true) {
            $converter !== null && method_exists($converter, 'getRepository') => $converter->getRepository(),
            default => app(FakeRepository::class)
        };
    }

    public function getProvider(): string
    {
        return 'internal';
    }

    public function getConverters(): array
    {
        return [
            (new Foo)->getMorphClass() => FooConverter::class,
        ];
    }

    public function getConverterForMorphedModel(string $alias): string
    {
        if (empty($this->getConverters()[$alias])) {
            throw FluxException::missingMorphedModelConverterForDriver($alias, $this->getProvider());
        }

        if (! is_a($this->getConverters()[$alias], RowConverter::class, allow_string: true)) {
            throw new \LogicException(
                sprintf(
                    "Converter '%s' must implement '%s' interface.",
                    $this->getConverters()[$alias],
                    RowConverter::class,
                ),
            );
        }

        return $this->getConverters()[$alias];
    }

    public function getModelForConverter(string $converter): ?string
    {
        $reversedConverters = array_flip($this->getConverters());

        return $reversedConverters[$converter] ?? null;
    }
}
