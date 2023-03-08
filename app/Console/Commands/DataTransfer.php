<?php

namespace App\Console\Commands;

use App\HelperClasses\Migrator\DistrictMigrator;
use App\HelperClasses\Migrator\LgMigrator;
use App\HelperClasses\Migrator\ProvinceMigrator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DataTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:previous_data';

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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
//        ProvinceMigrator::execute();
        LgMigrator::execute();
//        DistrictMigrator::execute();


        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
