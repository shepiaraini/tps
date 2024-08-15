<?php

namespace App\Services;

use GuzzleHttp\Client;

class TelegramService
{
    protected $telegramBotTokens;
    protected $client;

    public function __construct()
    {
        $this->telegramBotTokens = [
            'default' => config('services.telegram.bot_token'),
            'second' => config('services.telegram.bot_token_2'),
            'third' => config('services.telegram.bot_token_3'), // Tambahkan token ketiga
        ];
        $this->client = new Client();
    }

    public function sendMessage($chatId, $message, $botKey = 'third')
    {
        try {
            if (!array_key_exists($botKey, $this->telegramBotTokens)) {
                throw new \InvalidArgumentException("Invalid bot key: {$botKey}");
            }

            $token = $this->telegramBotTokens[$botKey];
            $url = "https://api.telegram.org/bot{$token}/sendMessage";
            $params = [
                'chat_id' => $chatId,
                'text' => $message,
            ];

            $response = $this->client->post($url, ['json' => $params]);
            \Log::info('Telegram response', ['botKey' => $botKey, 'response' => $response->getBody()->getContents()]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Telegram sendMessage error', ['botKey' => $botKey, 'error' => $e->getMessage()]);
            return false;
        }
    }
}