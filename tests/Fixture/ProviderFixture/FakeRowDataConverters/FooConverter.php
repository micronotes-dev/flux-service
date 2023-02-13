<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowDataConverters;

use Illuminate\Database\Eloquent\Builder;
use JetBrains\PhpStorm\Pure;
use Micronotes\Flux\DataTransferObjects\Reference;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels\Foo;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowConverter;

class FooConverter implements FakeRowConverter
{
    final public function __construct(
        public readonly Reference $reference,
        public readonly string $foo = 'bar',
        public readonly ?array $data = null,
    ) {
    }

    #[Pure] public static function fromRows(array $providerRows): iterable
    {
        $rows = [];
        foreach ($providerRows as $row) {
            $rows[] = self::fromProvider(
                reference: new Reference(
                    id: $row['uuid'],
                ),
                data: (array) $row,
            );
        }

        return $rows;
    }

    #[Pure]
    public static function fromProvider(Reference $reference, ?array $data): FooConverter
    {
        return new self(
            reference: $reference,
            foo: 'baz',
            data: $data,
        );
    }

    #[Pure]
    public function toProvider(): array
    {
        return $this->toArray();
    }

    public function getMorphModelAlias(): string
    {
        return 'foo';
    }

    public function hasReference(): bool
    {
        return true;
    }

    public function getReference(): Reference
    {
        return $this->reference;
    }

    public function toQuery(): ?Builder
    {
        return Foo::query()->where('uuid', $this->reference->id);
    }

    public function toArray(): array
    {
        return [
            'reference' => $this->reference->id,
            'data' => $this->data,
            'foo' => $this->foo,
        ];
    }
}
