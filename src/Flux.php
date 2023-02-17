<?php

namespace Micronotes\Flux;

use Illuminate\Database\Eloquent\Model;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\Concerns\Contracts\Upsertable;
use Micronotes\Flux\DataTransferObjects\FailedFluxMessage;
use Micronotes\Flux\Enums\FluxStatus;
use Micronotes\Flux\Events\Exported;
use Micronotes\Flux\Events\ExportFailed;
use Micronotes\Flux\Events\Exporting;
use Micronotes\Flux\Events\Imported;
use Micronotes\Flux\Events\ImportFailed;
use Micronotes\Flux\Events\Importing;

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

    public function export(FluxExport $exportCommand): void
    {
        foreach ($exportCommand->models as $model) {
            /** @var RowConverter $converterData */
            $converterData = $exportCommand->driver->getConverterForMorphedModel($model->getMorphClass());
            $exportCommand->converters[$model->getKey()] = $converterData::fromModel($model);
        }

        foreach ($exportCommand->converters as $converter) {
            event(new Exporting(converter: $converter));
            try {
                $exportCommand->driver->getRepository()->updateOrCreate($converter);
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
        // todo batch param?
//        $morphedModelClass = $importCommand->driver->getConverterForMorphedModel($importCommand->modelAlias);
//        /** @var Model $modelInstance */
//        $modelInstance = new $morphedModelClass;
//        $uniqueBy = $modelInstance instanceof Upsertable::class ?
//            $modelInstance->getUpsertable()->uniqueBy
//            : null;

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
}
