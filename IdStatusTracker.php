<?php

namespace Wruczek\IdStatusTracker;

use Wruczek\IdStatusTracker\ObywatelApi;
use Wruczek\IdStatusTracker\TelegramApi;

class IdStatusTracker {

    private $applicationId;
    private $telegramBotToken;
    private $telegramChatId;
    private $cacheFile;
    private $checkInterval;
    private $tracker;
    private $telegram;

    public function __construct($applicationId, $telegramBotToken, $telegramChatId, $cacheFile, $checkInterval) {
        $this->applicationId = $applicationId;
        $this->telegramBotToken = $telegramBotToken;
        $this->telegramChatId = $telegramChatId;
        $this->cacheFile = $cacheFile;
        $this->checkInterval = $checkInterval;
    }

    public function run() {
        $this->tracker = new ObywatelApi();
        $this->telegram = new TelegramApi($this->telegramBotToken);

        $this->telegram->sendMarkdownMessage($this->telegramChatId, "Bot has been successfully started 👌");
        
        while (true) {
            $this->checkStatus();
            sleep($this->checkInterval);
        }
    }

    private function checkStatus() {
        try {
            $status = $this->tracker->getIdStatus($this->applicationId);
            $statusDescription = $this->tracker->getStatusDescription($status->statusWniosku, $status->statusDowodu);
            $statusArray = [$status->statusWniosku, $status->statusDowodu];
            $state = $status->statusWniosku . (" $status->statusDowodu" ?: "");

            echo "Current state: $state";
            echo ($statusDescription ? " ($statusDescription)" : "") . PHP_EOL;

            if ($this->readCache() != $statusArray) {
                if ($this->writeCache($statusArray) === false) {
                    echo "ERROR writing to file " . $this->cacheFile . ", make sure the file is writable." . PHP_EOL;
                    exit;
                }

                echo "Status updated, sending message!" . PHP_EOL;
                $this->telegram->sendMarkdownMessage($this->telegramChatId, "ID Status updated: $statusDescription `($state)`");
            }
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    private function readCache() {
        return unserialize(file_get_contents($this->cacheFile));
    }

    private function writeCache($data) {
        return file_put_contents($this->cacheFile, serialize($data));
    }
}
