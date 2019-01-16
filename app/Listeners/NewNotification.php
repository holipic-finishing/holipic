<?php

namespace App\Listeners;

use App\Events\RedisEventNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use NNV\OneSignal\OneSignal;
use NNV\OneSignal\API\Notification;
use Log;

class NewNotification
{
     private $oneSignal;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->oneSignal = new OneSignal(
            env("ONESIGNAL_AUTH_KEY"), env("ONESIGNAL_APP_ID"), env("ONESIGNAL_APP_REST_KEY")
        );
    }

    /**
     * Handle the event.
     *
     * @param  RedisEventNotification  $event
     * @return void
     */
    public function handle(RedisEventNotification $event)
    {
        $domain = env("MIX_APP_PROTOCOL")  . "://" . env("MIX_APP_DOMAIN");
        $oneSingalNotification = new Notification($this->oneSignal);
        $notification = $event->notification;
        $notificationData = [
            "included_segments" => ["All"],
            "contents" => [
                "en" => $notification->push_notification,
            ],
            "headings" => [
                "en" => 'Notification',
            ],
            "web_buttons" => [
                [
                    "id" => "readmore-button",
                    "text" => "Click",
                    "url" =>  $domain . '/login',
                ]
            ],
            "isChromeWeb" => true,
        ];

         $createNotification = $oneSingalNotification->create($notificationData);
         // Log::info($createNotification);
    }
}
