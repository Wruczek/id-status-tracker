<?php

use Wruczek\IdStatusTracker\IdStatusTracker;

require_once __DIR__ . "/TelegramApi.php";
require_once __DIR__ . "/ObywatelApi.php";
require_once __DIR__ . "/IdStatusTracker.php";

// Config
$applicationId = "xxxxxxx/xxxx/xxxxxxx/xx";
$telegramBotToken = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
$telegramChatId = "000000000";
$cacheFile = __DIR__ . "/idTrackerCache.txt";
$checkInterval = 300;
// End of config

touch($cacheFile);
if (!is_writable($cacheFile)) {
    echo "$cacheFile must be writable" . PHP_EOL;
    exit;
}

$idStatusTracker = new IdStatusTracker(
    $applicationId, $telegramBotToken, $telegramChatId, $cacheFile, $checkInterval
);

echo "Starting bot..." . PHP_EOL;
$idStatusTracker->run();
