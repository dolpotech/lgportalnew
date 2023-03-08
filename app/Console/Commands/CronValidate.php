<?php

namespace App\Console\Commands;

use App\HelperClasses\CronValidator\Article;
use App\HelperClasses\CronValidator\Contact;
use App\HelperClasses\CronValidator\Document;
use App\HelperClasses\CronValidator\Electedofficials;
use App\HelperClasses\CronValidator\ElectedProfile;
use App\HelperClasses\CronValidator\EmergencyNumbers;
use App\HelperClasses\CronValidator\Gallery;
use App\HelperClasses\CronValidator\ImportantPlaces;
use App\HelperClasses\CronValidator\Introduction;
use App\HelperClasses\CronValidator\ResourceMaps;
use App\HelperClasses\CronValidator\Service;
use App\HelperClasses\CronValidator\Slider;
use App\HelperClasses\CronValidator\Staff;
use App\HelperClasses\CronValidator\Ward;
use App\HelperClasses\CronValidator\WardOfficials;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CronValidate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:data';

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
        Article::execute();
        Contact::execute();
        Document::execute();
        Electedofficials::execute();
        ElectedProfile::execute();
        EmergencyNumbers::execute();
        Gallery::execute();
        ImportantPlaces::execute();
        Introduction::execute();
        ResourceMaps::execute();
        Service::execute();
        Slider::execute();
        Staff::execute();
        Ward::execute();
        WardOfficials::execute();
        $contents="Database has been updated";
        Storage::disk('api')->put('test2.txt', $contents);


    }
}
