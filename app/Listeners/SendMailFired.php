<?php

namespace App\Listeners;

use App\Events\SendMail;
use App\Mail\SendInformationCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailFired implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 60;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        foreach ($event->emails as $email) {
            Mail::to($email)->send(new SendInformationCreatedMail($event->title, $event->description));
        }
    }
}
