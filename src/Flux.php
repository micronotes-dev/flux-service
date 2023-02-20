<?php

namespace Micronotes\Flux;

use Illuminate\Database\Eloquent\Model;
use Micronotes\Flux\Concerns\AbstractFluxRepository;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\Concerns\Contracts\Upsertable;
use Micronotes\Flux\DataTransferObjects\FailedFluxMessage;
use Micronotes\Flux\Enums\FluxStatus;
use Micronotes\Flux\Events\Batched;
use Micronotes\Flux\Events\Exported;
use Micronotes\Flux\Events\ExportFailed;
use Micronotes\Flux\Events\Exporting;
use Micronotes\Flux\Events\Imported;
use Micronotes\Flux\Events\ImportFailed;
use Micronotes\Flux\Events\Importing;
use Micronotes\Flux\Events\StartBatching;

/**
 * @internal
 */
class Flux
{
    public function import(FluxImport $importCommand): void
    {
        try {
            $importCommand->retrievedConverters = $importCommand->driver->getRepository()->search($importCommand->filters);
        } catch (\Exception $exception) {
            $importCommand->status = FluxStatus::failed;
        }

        if (! $importCommand->dryRun) {
            $this->persistImport($importCommand);

            match (true) {
                ! empty($importCommand->failed) && ! empty($importCommand->imported) => $importCommand->status = FluxStatus::partial,
                empty($importCommand->imported) => $importCommand->status = FluxStatus::failed,
                default => $importCommand->status = FluxStatus::success,
            };
        }
    }

    public function export(FluxExport $exportCommand, ?AbstractFluxRepository $customRepository = null, bool $withBatch = false): void
    {
        $this->prepareConverters($exportCommand);

        $repository = $customRepository ?: $exportCommand->driver->getRepository();

        if ($withBatch) {
            event(new StartBatching);
            $exportCommand->exported = $repository->updateOrCreate($exportCommand->converters);
            event(new Batched);

            return;
        }

        foreach ($exportCommand->converters as $converter) {
            event(new Exporting(converter: $converter));
            try {
                $repository->updateOrCreate([$converter]);
                event(new Exported(converter: $converter));
                $exportCommand->exported[] = $converter->getReference();
            } catch (\Exception $exception) {
                $exportCommand->failed[] = new FailedFluxMessage(
                    reference: $converter->getReference(),
                    message: $exception->getMessage(),
                );
                event(new ExportFailed($converter));
            }
        }
    }

    public function persistImport(FluxImport $importCommand): void
    {
        // todo add $converter chunkable interface/trait
        // chunk and dispatch a job

        foreach ($importCommand->retrievedConverters as $converter) {
            try {
                $model = null;

                event(new Importing($converter));

                $modelClass = $importCommand->driver->getModelForConverter($converter::class);

                if ($modelClass === null) {
                    continue;
                }

                $model = new $modelClass($converter->toArray());
                $model->save();

                event(new Imported(model: $model, converter: $converter));

                $importCommand->imported[$converter->getReference()->id] = $model;
            } catch (\Exception $exception) {
                $importCommand->failed[] = new FailedFluxMessage(
                    reference: $converter->getReference(),
                    message: $exception->getMessage(),
                );
                event(new ImportFailed($converter));
            }
        }
    }

    private function prepareConverters(FluxExport $exportCommand): void
    {
        foreach ($exportCommand->models as $model) {
            /** @var RowConverter $converterData */
            $converterData = $exportCommand->driver->getConverterForMorphedModel($model->getMorphClass());
            $exportCommand->converters[$model->getKey()] = $converterData::fromModel($model);
        }
    }
}
