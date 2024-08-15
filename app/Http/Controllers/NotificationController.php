<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function sendNotification(Request $request)
    {
        $chatId = $request->input('chat_id');
        $message = $request->input('message');

        $this->telegramService->sendMessage($chatId, $message);

        return response()->json(['status' => 'Message sent successfully!']);
    }
}