<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\WebPushConfig;

class FirebaseService
{
  protected $messaging;

  public function __construct()
  {
    $factory = (new Factory)->withServiceAccount(storage_path('app/firebase/service-account.json'));
    $this->messaging = $factory->createMessaging();
  }

  public function sendNotification($token, $title, $body, $data = [])
  {
    try {
      $notification = Notification::create($title, $body);

      $message = CloudMessage::withTarget('token', $token)
        ->withNotification($notification)
        ->withData($data)
        ->withAndroidConfig(AndroidConfig::fromArray([
          'priority' => 'high',
        ]))
        ->withApnsConfig(ApnsConfig::fromArray([
          'headers' => ['apns-priority' => '10'],
        ]))
        ->withWebPushConfig(WebPushConfig::fromArray([
          'headers' => ['TTL' => '4500'],
        ]));


      $this->messaging->send($message);

      return ['success' => true, 'message' => 'Notification send successfully'];
    } catch (MessagingException $e) {
      Log::error('MessagingException: ' . $e->getMessage());
      return ['success' => false, 'message' => $e->getMessage()];
    }
  }
}
