<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowDataConverters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Micronotes\Flux\DataTransferObjects\Reference;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels\Foo;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowConverter;

class FooConverter implements FakeRowConverter
{
    final public function __construct(
        public readonly Reference $reference,
        public readonly Reference $fake_reference,
        public readonly string $foo = 'bar',
        public readonly ?array $data = null,
    ) {
    }

     public static function fromRows(array $providerRows): iterable
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

    public static function fromProvider(Reference $reference, ?array $data): static
    {
        return new self(
            reference: $reference,
            fake_reference: Reference::generate(),
            foo: 'baz',
            data: $data,
        );
    }

    public function toProvider(): array
    {
        return $this->toArray();
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

    public function model(): ?string
    {
        return Foo::class;
    }

    public static function fromModel(Model $model): static
    {
        return new static(
            reference: new Reference(id: $model->getRouteKey()),
            fake_reference: Reference::empty(),
            foo: fake()->word,
            data: $model->getAttribute('data'),
        );
    }

    public function getProviderReference(): Reference
    {
        return $this->fake_reference;
    }
}
