<?php

namespace Micronotes\Flux;

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
        $importCommand->retrievedConverters = $importCommand->driver->getRepository()->search($importCommand->filters);

        if (!$importCommand->dryRun) {
            $this->persistImport($importCommand);

            match (true) {
                !empty($importCommand->failed) && !empty($importCommand->imported) => $importCommand->status = FluxStatus::partial,
                empty($importCommand->imported) => $importCommand->status = FluxStatus::failed,
                default => $importCommand->status = FluxStatus::success,
            };
        }
    }

    public function export(FluxExport $exportCommand)
    {
    }

    public function run()
    {
    }

    public function dryRun()
    {
    }

    private function persistImport(FluxImport $importCommand): void
    {
        foreach ($importCommand->retrievedConverters as $converter) {
            try {
                $model = null;

                event(new Importing($converter));

                $modelClass = $importCommand->driver->getModelForConverter($converter::class);

                if ($modelClass === null) {
                    continue;
                }

                $model = (new $modelClass())($converter->toArray());
                $model->save();

                event(new Imported(model: $model, converter: $converter));

                $importCommand->imported[] = $converter->getReference();
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
