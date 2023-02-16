<?php

namespace Micronotes\Flux;

use Illuminate\Database\Eloquent\Model;
use Micronotes\Flux\Concerns\Contracts\Upsertable;
use Micronotes\Flux\DataTransferObjects\FailedImportMessage;
use Micronotes\Flux\Enums\FluxStatus;
use Micronotes\Flux\Events\Imported;
use Micronotes\Flux\Events\ImportFailed;
use Micronotes\Flux\Events\Importing;
use function Pest\Laravel\delete;

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

        if (!$importCommand->dryRun) {
            $this->persistImport($importCommand);

            match (true) {
                !empty($importCommand->failed) && !empty($importCommand->imported) => $importCommand->status = FluxStatus::partial,
                empty($importCommand->imported) => $importCommand->status = FluxStatus::failed,
                default => $importCommand->status = FluxStatus::success,
            };
        }
    }

    public function export(FluxExport $exportCommand): void
    {
        $exportCommand->status = FluxStatus::success;
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
                $importCommand->failed[] = new FailedImportMessage(
                    reference: $converter->getReference(),
                    message: $exception->getMessage(),
                );
                event(new ImportFailed($converter));
            }
        }
    }
}
