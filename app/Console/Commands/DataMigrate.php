<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DataMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:migrate';

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
        $tables=[
            'articles',
            'contacts',
            'lg_documents',
            'elected_officials',
            'elected_profiles',
            'galleries',
            'important_places',
            'resource_maps',
            'introductions',
            'staffs',
            'wards',
            'ward_officials',
            'services',
            'sliders',
            'emergency_numbers'
        ];
        foreach($tables as $table){
              DB::table($table)
                ->where('lg_id', 533)
                ->orWhere('lg_id', 541)
                ->orWhere('lg_id', 543)
                ->delete();
              echo "completed deleting".$table;
        }

    }
}
