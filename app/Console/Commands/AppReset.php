<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class AppReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset';

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
        ini_set('memory_limit', '500M');
        // Artisan::call('backup:templates');
        $this->info('template data backed up');
        Artisan::call('migrate:fresh');
        $this->info("DB Migrated");

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($this->getTables() as $table) {
            DB::table($table)->truncate();
            $data = json_decode(file_get_contents(storage_path('app/database' . DIRECTORY_SEPARATOR . $table . '.json')), true);
            foreach (array_chunk($data, 1000) as $groupedData) {
                DB::table($table)->insert($groupedData);
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        $this->info("Imported Json to DB");

        Artisan::call('db:seed');
        $this->info("DB Seeded");


        Artisan::call('cache:clear');
        $this->info("Cache Cleared");

        $this->info("API Data Seeded");
    }



    /**
     * Get Array of Tables
     *
     * @return array
     */
    public function getTables()
    {
        return [
            'provinces',
            'districts',
            'local_governments',
            'articles',
            'lg_documents',
            'elected_officials',
            'elected_profiles',
            'galleries',
            'important_places',
            'contacts',
            'resource_maps',
            'introductions',
            'staffs',
            'wards',
            'ward_officials',
            'services',
            'sliders',
            'emergency_numbers',
            'templates',
            'template_fields'
        ];
    }
}
