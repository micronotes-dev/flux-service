<?php

namespace Micronotes\Flux\Commands;

use Illuminate\Console\Command;

/**
 * @todo
 * - add arguments for except|only converters
 */
class ExportFluxCommand extends Command
{
    public $signature = 'flux:export
                        {driver}
                        {--n|dry-run : count the number per converters which can be retrieved from driver}
                        {--converters=* : the converters to export}';

    public $description = 'Export flux from chosen provider and converters';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
