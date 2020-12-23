<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class MessageController extends Controller
{
    private $messaging = [];

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function sendMessage()
    {
        $notification = Notification::create('title', 'body');
        $topic = 'test';

        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification($notification)
            ->withData(['key' => 'value']);
        
        $this->messaging->send($message);
    }
}
