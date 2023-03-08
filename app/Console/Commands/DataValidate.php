<?php

namespace App\Console\Commands;


use App\HelperClasses\Validator\Article;
use App\HelperClasses\Validator\Contact;
use App\HelperClasses\Validator\Document;
use App\HelperClasses\Validator\Electedofficials;
use App\HelperClasses\Validator\ElectedProfile;
use App\HelperClasses\Validator\EmergencyNumbers;
use App\HelperClasses\Validator\Gallery;
use App\HelperClasses\Validator\ImportantPlaces;
use App\HelperClasses\Validator\Introduction;
use App\HelperClasses\Validator\ResourceMaps;
use App\HelperClasses\Validator\Service;
use App\HelperClasses\Validator\Slider;
use App\HelperClasses\Validator\Staff;
use App\HelperClasses\Validator\Ward;
use App\HelperClasses\Validator\WardOfficials;
use Illuminate\Console\Command;


class DataValidate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate API Data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Article::execute();
        Document::execute();
        Contact::execute();
        Electedofficials::execute();
        ElectedProfile::execute();
        Gallery::execute();
        ImportantPlaces::execute();
        ResourceMaps::execute();
        Service::execute();
        Slider::execute();
        WardOfficials::execute();
        Ward::execute();
        Staff::execute();
        Introduction::execute();
        EmergencyNumbers::execute();
    }
}
