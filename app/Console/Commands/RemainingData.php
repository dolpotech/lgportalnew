<?php

namespace App\Console\Commands;

use App\HelperClasses\Fetcher\Remainingdatafetch;
use Illuminate\Console\Command;

class RemainingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:remain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      Remainingdatafetch::execute();
    }
}
