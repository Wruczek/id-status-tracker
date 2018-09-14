#!/bin/sh
cd "$(dirname "$0")"
screen -dmS id-tracker-bot php bootstrap.php
echo "Bot started"
