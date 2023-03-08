<?php

namespace App\Console\Commands;

use App\HelperClasses\Fetcher\ArticlesFetcher;
use App\HelperClasses\Fetcher\ContactFetcher;
use App\HelperClasses\Fetcher\DocumentsFetcher;
use App\HelperClasses\Fetcher\ElectedOfficials;
use App\HelperClasses\Fetcher\ElectedProfile;
use App\HelperClasses\Fetcher\EmergencyNumbers;
use App\HelperClasses\Fetcher\GalleryFetcher;
use App\HelperClasses\Fetcher\ImportantPlaces;
use App\HelperClasses\Fetcher\Introduction;
use App\HelperClasses\Fetcher\ResourceMap;
use App\HelperClasses\Fetcher\ServiceFetcher;
use App\HelperClasses\Fetcher\Slider;
use App\HelperClasses\Fetcher\StaffsFetcher;
use App\HelperClasses\Fetcher\WardOfficials;
use App\HelperClasses\Fetcher\WardsFetcher;
use App\Models\LocalGovernment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DataFetcher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:data';

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
        ArticlesFetcher::execute();
        DocumentsFetcher::execute();
        WardsFetcher::execute();
        ResourceMap::execute();
        GalleryFetcher::execute();
        ServiceFetcher::execute();
        ContactFetcher::execute();
        WardOfficials::execute();
        ElectedProfile::execute();
        ImportantPlaces::execute();
        ElectedOfficials::execute();
        Slider::execute();
        StaffsFetcher::execute();
        Introduction::execute();
        EmergencyNumbers::execute();
    }
}
