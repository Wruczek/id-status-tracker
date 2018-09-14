## id-status-tracker

Prosty programik śledzący status wniosku o dowód osobisty. Wysyła powiadomienia o zmianie statusu na [Telegram](https://telegram.org/)ie

### Użytkowanie

#### Potrzebujesz:
- serwer, na którym chcesz właczyć bota. Może być to serwer VPS lub twój komputer. Pamiętaj, by otrzymać powiadomienia, program musi być włączony.
- Linux (preferowany), Mac lub Windows
- PHP - min. 5.6, najlepiej najnowsza wersja (nie wymaga serwera WWW)
  - JSON
  - PCRE

### Instalacja PHP na czystym Ubuntu 18.04
```
sudo apt update && sudo apt upgrade
sudo apt install php-fpm php-json
```

### Instalacja id-status-checker
```
sudo apt install unzip -y
wget https://github.com/Wruczek/id-status-tracker/archive/master.zip
unzip master.zip
rm master.zip
cd id-status-tracker-master
```

### Skonfiguruj program
W pliku `bootstrap.php` zmień następujące wartości:

```php
$applicationId = "xxxxxxx/xxxx/xxxxxxx/xx";
$telegramBotToken = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
$telegramChatId = "000000000";
```

`$applicationId` - ID wniosku o dowód osobisty<br>
`$telegramBotToken` - Token twojego bota na Telegramie<br>
`$telegramChatId` - ID chatu, do którego bot powinien wysyłać powiadomienia

### Uruchom
W folderze z programem:
```
chmod +x start.sh
./start.sh
```
