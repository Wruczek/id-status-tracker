## id-status-tracker

Prosty programik śledzący status wniosku o dowód osobisty. Wysyła powiadomienia o zmianie statusu na [Telegram](https://telegram.org/)ie

<a href="https://i.imgur.com/vckPwq0.png" target="_blank">
  <img src="https://i.imgur.com/vckPwq0.png" width="300px">
</a>

## Użytkowanie

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

### Instalacja id-status-tracker
```
sudo apt install unzip screen
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

**By otrzymać token:**
- Zagadaj do <a href="https://telegram.me/botfather" target="_blank">BotFathera</a>
- Stwórz nowego bota komendą `/newbot`, śledź polecenia Ojca
- Skopiuj token i wklej go do configu.

**By otrzymac chatId: <a href="https://stackoverflow.com/a/32572159/5381375" target="_blank">klik</a>**

### Uruchom
W folderze z programem:
```
chmod +x start.sh
./start.sh
```

Sprawdź status programu, czy wszystko włączyło się poprawnie:
```
screen -r id-tracker-bot
```
**Jeżeli wszystko skonfigurowałeś prawidłowo, powinieneś otrzymać dwie wiadomości od bota:**
- informację, że bot został uruchomiony poprawnie
- przy pierwszym uruchomieniu: aktualny status dowodu osobistego

### Zatrzymanie bota

- Przejdź na screen bota: `screen -r id-tracker-bot`<br>
- Naciśnij <kbd>CTRL + C</kbd>
