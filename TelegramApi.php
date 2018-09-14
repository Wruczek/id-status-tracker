<?php

namespace Wruczek\IdStatusTracker;

class TelegramApi {

    private $telegramBotToken;
    private $apiUrl = "https://api.telegram.org/bot%s";

    public function __construct($telegramBotToken) {
        $this->telegramBotToken = $telegramBotToken;
        $this->apiUrl = sprintf($this->apiUrl, $telegramBotToken);
    }

    public function sendMarkdownMessage($chatId, $message) {
        $data = [
            "text" => $message,
            "chat_id" => $chatId,
            "parse_mode" => "Markdown"
        ];

        return file_get_contents($this->apiUrl . "/sendMessage?" . http_build_query($data));
    }
}
