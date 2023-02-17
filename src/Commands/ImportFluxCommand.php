<?php

namespace Micronotes\Flux\Commands;

use Illuminate\Console\Command;

class ImportFluxCommand extends Command
{
    public $signature = 'flux:import
                        {driver}
                        {--n|dry-run : count the number per converters which can be retrieved from driver}
                        {--converters=* : the converters to import}';

    public $description = 'Import flux from chosen provider and converters';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
