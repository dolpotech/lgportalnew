<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:test';

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
        $contents="Hello world";
        Storage::put('test.txt', $contents);
        $this->info('Test successful');
    }
}
