<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Templatedata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:templates';

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
            'templates',
            'template_fields'
        ];
        foreach ($tables as $table)
        {
            Storage::disk('api')->delete('database/'.$table.'.json');
            $table_data=DB::table($table)->get();
            Storage::disk('api')->put('database/'.$table.'.json', json_encode($table_data, JSON_PRETTY_PRINT));
        }
    }

}
