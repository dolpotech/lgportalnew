<?php

namespace App\Console\Commands;

use App\Models\LocalGovernment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class CronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup local government website data daily';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '500M');
/*        $memory_limit = ini_get('memory_limit');
        dd($memory_limit);*/

        $outputMessage = "";
        $curl_arr = array();
        $master = curl_multi_init();

        $files = [
            'articles',
            'contact',
            'documents',
            'elected-officials',
            'elected-profile',
            'emergency-numbers',
            'gallery',
            'important-places',
            'introduction',
            'services',
            'slider',
            'staff',
            'ward-officials',
            'wards'
        ];
        Artisan::call('cache:clear');
        $outputMessage .= "Cache Cleared \n";

        $time_start = microtime(true);


        foreach ($files as $file) {
            Storage::disk('api')->delete('cronjob/' . $file . '.json');
            $dataStore = [];
            $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();
            $i=0;
            $j=0;
            foreach($lgs as $lg){
                $url=$lg->website.'/'.$file.'-api';
                $curl_arr[$i] = curl_init($url);
                curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
                curl_multi_add_handle($master, $curl_arr[$i]);
                $i++;
            }
            do {
                curl_multi_exec($master,$running);
            } while($running > 0);

            echo "results: ";
            foreach($lgs as $lg)
            {
                $dataStore[$lg->id] = json_decode(curl_multi_getcontent ( $curl_arr[$j]  ));
                $j++;
            }


            Storage::disk('api')->put('cronjob/' . $file . '.json', json_encode($dataStore, JSON_PRETTY_PRINT));

        }

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start) / 60;
        echo '<b>Total Execution Time:</b> ' . $execution_time . "Mins \n";
        //Storage::put('cron_output.txt', $outputMessage);
        curl_multi_close($master);
        $this->info('lg data completely backed up');
    }

}
