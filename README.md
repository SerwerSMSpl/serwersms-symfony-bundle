# SerwerSMSBundle - Symfony

Klient PHP dla frameworka Symfony do komunikacji z API v2 SerwerSMS.pl

Zalecane jest, aby komunikacja przez HTTPS API odbywała się z loginów utworzonych specjalnie do połączenia przez API. Konto użytkownika API można utworzyć w Panelu Klienta → Ustawienia interfejsów → HTTP API → Użytkownicy API.

## Wymagania

- PHP >= 8.4
- Symfony >= 8.1

## Instalacja

Przez Composer:

```bash
composer require serwersms/serwersmsbundle
```

Lub ręcznie w `composer.json`:

```json
{
    "require": {
        "serwersms/serwersmsbundle": "^2.0"
    }
}
```

## Konfiguracja

### Opcja 1 — autentykacja przez token

```yaml
# config/packages/serwer_sms.yaml
serwer_sms:
    serwersms_token: '%env(SERWERSMS_TOKEN)%'
```

### Opcja 2 — autentykacja przez username i password

```yaml
# config/packages/serwer_sms.yaml
serwer_sms:
    serwersms_username: '%env(SERWERSMS_USERNAME)%'
    serwersms_password: '%env(SERWERSMS_PASSWORD)%'
```

Opcjonalne parametry dla obu opcji:

```yaml
serwer_sms:
    # ...
    serwersms_api_url: 'https://api2.serwersms.pl'  # domyślnie
    serwersms_timeout: 30                            # domyślnie
```

### Opcja 3 — rejestracja ręczna w services.yaml

Zamiast konfiguracji bundla, klasę można zarejestrować bezpośrednio jako serwis Symfony:

Z tokenem:

```yaml
# config/services.yaml
services:
    serwer_sms:
        class: SerwerSMS\SerwerSMSBundle\SerwerSMSToken
        public: true
        arguments:
            - '%env(SERWERSMS_TOKEN)%'

    SerwerSMS\SerwerSMSBundle\SerwerSMSInterface: '@serwer_sms'
```

Z username i password:

```yaml
# config/services.yaml
services:
    serwer_sms:
        class: SerwerSMS\SerwerSMSBundle\SerwerSMS
        public: true
        arguments:
            - '%env(SERWERSMS_USERNAME)%'
            - '%env(SERWERSMS_PASSWORD)%'

    SerwerSMS\SerwerSMSBundle\SerwerSMSInterface: '@serwer_sms'
```

## Użycie w kontrolerze

```php
namespace App\Controller;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class SmsController extends AbstractController
{
    public function __construct(private SerwerSMSInterface $serwerSms)
    {
    }

    #[Route('/send-sms')]
    public function sendSms(): JsonResponse
    {
        try {

            $result = $this->serwerSms->messages()->sendSms(
                [
                    '+48500600700',
                    '+48600700800'
                 ],
                'Test FULL message',
                'INFORMACJA',
                [
                    'test' => true,
                    'details' => true
                ]
            );

            return new JsonResponse($result);

        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
```

## Przykłady

```php
try {

    // SMS FULL
    $result = $this->serwerSms->messages()->sendSms(
        [
            '+48500600700',
            '+48600700800'
        ],
        'Test FULL message',
        'INFORMACJA',
        [
            'test' => true,
            'details' => true
        ]
    );

    // SMS ECO
    $result = $this->serwerSms->messages()->sendSms(
        [
            '+48500600700',
            '+48600700800'
        ],
        'Test ECO message',
        null,
        [
            'test' => true,
            'details' => true
        ]
    );

    // VOICE from text
    $result = $this->serwerSms->messages()->sendVoice(
        [
            '+48500600700',
            '+48600700800'
        ],
        [
            'text' => 'Test message',
            'test' => true,
            'details' => true
        ]
    );

    // MMS
    $list = $this->serwerSms->files()->index('mms');
    $result = $this->serwerSms->messages()->sendMms(
        [
            '+48500600700',
            '+48600700800'
        ],
        'MMS Title',
        [
            'test' => true,
            'file_id' => $list->items[0]->id,
            'details' => true
        ]
    );

    echo 'Skolejkowano: ' . $result->queued . '<br />';
    echo 'Niewysłano: ' . $result->unsent . '<br />';

    foreach ($result->items as $sms) {
        echo 'ID: ' . $sms->id . '<br />';
        echo 'NUMER: ' . $sms->phone . '<br />';
        echo 'STATUS: ' . $sms->status . '<br />';
        echo 'CZĘŚCI: ' . $sms->parts . '<br />';
        echo 'WIADOMOŚĆ: ' . $sms->text . '<br />';
    }

} catch (\Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
```

### Wysyłka spersonalizowanych SMS

```php
try {

    $messages[] = [
        'phone' => '500600700',
        'text' => 'First message'
    ];
    $messages[] = [
        'phone' => '600700800',
        'text' => 'Second message'
    ];

    $result = $this->serwerSms->messages()->sendPersonalized(
        $messages,
        'INFORMACJA',
        [
            'test' => true,
            'details' => true
        ]
    );

    echo 'Skolejkowano: ' . $result->queued . '<br />';
    echo 'Niewysłano: ' . $result->unsent . '<br />';

    foreach ($result->items as $sms) {
        echo 'ID: ' . $sms->id . '<br />';
        echo 'NUMER: ' . $sms->phone . '<br />';
        echo 'STATUS: ' . $sms->status . '<br />';
        echo 'CZĘŚCI: ' . $sms->parts . '<br />';
        echo 'WIADOMOŚĆ: ' . $sms->text . '<br />';
    }

} catch (\Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
```

### Pobieranie raportów doręczeń

```php
try {

    $result = $this->serwerSms->messages()->reports(['id' => ['aca3944055']]);

    foreach ($result->items as $sms) {
        echo 'ID: ' . $sms->id . '<br />';
        echo 'NUMER: ' . $sms->phone . '<br />';
        echo 'STATUS: ' . $sms->status . '<br />';
        echo 'SKOLEJKOWANO: '. $sms->queued . '<br />';
        echo 'WYSŁANO: ' . $sms->sent . '<br />';
        echo 'DORĘCZONO: ' . $sms->delivered . '<br />';
        echo 'NADAWCA: ' . $sms->sender . '<br />';
        echo 'TYP: ' . $sms->type . '<br />';
        echo 'WIADOMOŚĆ: ' . $sms->text . '<br />';
    }

} catch (\Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
```

### Pobieranie wiadomości przychodzących

```php
try {

    $result = $this->serwerSms->messages()->received('ndi');

    foreach ($result->items as $sms) {
        echo 'ID: ' . $sms->id . '<br />';
        echo 'TYP: ' . $sms->type . '<br />';
        echo 'NUMER: ' . $sms->phone . '<br />';
        echo 'DATA: ' . $sms->received . '<br />';
        echo 'CZARNA LISTA: ' . $sms->blacklist . '<br />';
        echo 'WIADOMOŚĆ: ' . $sms->text . '<br />';
    }

} catch (\Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
```

## Dokumentacja API

http://dev.serwersms.pl

Konsola API: http://apiconsole.serwersms.pl/
