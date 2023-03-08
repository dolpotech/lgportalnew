<?php

namespace App\Console\Commands;

use App\Models\LocalGovernment;
use Illuminate\Console\Command;

class ExtraLg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:lg';

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
       $lg_data=[
           [
                'id'=>50104,
                'province_id'=>5,
               'district_id'=>501,
               'name'=>'ढोरपाटन शिकार आरक्ष',
               'name_en'=>'Dhorpatan Hunting Reserve',
               'website'=>'https://dnpwc.gov.np/en/conservation-area-detail/61/',
               'type'=>'Hunting Reserve',
               'type_nep'=>'शिकार आरक्ष'
           ],
           [
               'id'=>51209,
               'province_id'=>5,
               'district_id'=>512,
               'name'=>'बर्दिया राष्ट्रिय निकुञ्ज',
               'name_en'=>'Bardiya National Park',
               'website'=>'http://bardianationalpark.gov.np/en/',
               'type'=>'National Park',
               'type_nep'=>'राष्ट्रिय निकुञ्ज'

           ]
       ];
       LocalGovernment::insert($lg_data);
    }
}
