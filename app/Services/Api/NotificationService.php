<?php


namespace App\Services\Api;


use App\Events\SendMail;
use App\HelperClasses\Traits\AppHelper;
use App\HelperClasses\Traits\AuthHelper;
use App\Mail\SendInformationCreatedMail;
use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\MinistryOffices;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    use AppHelper, AuthHelper;


    public function sendInformationNotification(
        string $storeTo, array $dataIds,
        string $title, string $description,
        int $toMail, int $toSms
    )
    {
        if ($storeTo == 'local_government') {
            $mailTo = 'lg';
            $govIds = $dataIds;
            $data = LocalGovernment::whereIn('id', $dataIds)->get();
        }
        if ($storeTo == 'ministry') {
            $mailTo = 'ministry';
            $govIds = $dataIds;
            $data = Ministry::whereIn('id', $dataIds)->get();
        }
        if ($storeTo == 'ministry_office') {
            $mailTo = 'ministry_office';
            $govIds = $dataIds;
            $data = MinistryOffices::whereIn('id', $dataIds)->get();
        }

        $notifications = array_map(function ($govId) use ($mailTo, $title, $description, $toMail, $toSms) {
            return [
                'ministry_id' => ($mailTo == 'ministry') ? $govId : null,
                'office_id' => ($mailTo == 'ministry_office') ? $govId : null,
                'lg_id' => ($mailTo == 'lg') ? $govId : null,
                'title' => $title,
                'description' => $description,
                'to_email' => $toMail,
                'to_sms' => $toSms,
                'is_sent' => 1,
                'sent_count' => 1
            ];
        }, $govIds);

        DB::table('notifications')->insert($notifications);

        if ($toSms) {
//            $data->pluck('phone_no')->toArray();
            $this->sendSms([9817554146], $title); //9841524047
        }

        if($toMail){
             $this->sendEmail($data->pluck('email')->toArray(), $title, $description);
        }

//         $this->sendSms($data->pluck('phone_no')->toArray(),$description);
    }

    public function sendEmail($emails, $title, $description)
    {
        event(new SendMail($emails,$title, $description));

//        foreach ($emails as $email) {
//            Mail::to($email)->send(new SendInformationCreatedMail($title, $description));
//        }
    }

    public function sendSms(array $contacts, $message)
    {
        /*$api_url = "https://sms.codekarkhana.com/smsapi/index.php?key=2623D758883DBB&campaign=6406&routeid=116&type=text&contacts=9860357792&senderid=SmsBit&msg=Hello";
        return file_get_contents( $api_url);*/


        $url = 'https://sms.codekarkhana.com/smsapi/index.php';
        $apiKey = '2623D758883DBB';
        $contacts = implode(',', $contacts);
        $message = urlencode($message);
        $senderId = 'SmsBit';
        $campaign = '6406';
        $routeId = '116';

        $response = Http::get($url, [
            'key'       => $apiKey,
            'campaign'  => $campaign,
            'routeid'   => $routeId,
            'senderid'  => $senderId,
            'type'      => 'text',
            'contacts'  => $contacts,
            'msg'       => urlencode($message),
        ]);

        return $response->body();


        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sms.codekarkhana.com/smsapi/index.php?key=2623D758883DBB&campaign=6236&routeid=116&type=text&contacts=9817554146&senderid=SmsBit&msg=hlo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;*/
    }

    /**
     * Get Ministry Notification
     *
     * @return mixed
     */
    public function getMinistryNotification()
    {
        return Notification::where('ministry_id', $this->getAuthMinistryId())->get();
    }

    /**
     * Get Lg Notification
     *
     * @return mixed
     */
    public function getLgNotification()
    {
        return Notification::where('lg_id', $this->getAuthLgId())->get();
    }

    /**
     * Get Ministry Office Notification
     *
     * @return mixed
     */
    public function getMinistryOfficeNotification()
    {
        return Notification::where('office_id', $this->getAuthMinistryOfficeId())->get();
    }
}
