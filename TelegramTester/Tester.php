<?php

namespace TelegramTester;

use danog\MadelineProto\API;
use danog\MadelineProto\EventHandler\AbstractMessage;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Logger;
use danog\MadelineProto\RPCErrorException;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Settings\Logger as SettingsLogger;
use danog\MadelineProto\SettingsAbstract;
use danog\MadelineProto\TL\Types\Bytes;
use danog\MadelineProto\Tools;

class Tester implements Trial
{
    private const COMMAND_PREFIX = '/';

    private SettingsAbstract $settings;
    /**
     * @var Credible[]
     */
    private array $credentials;
    private Credible $credential;

    private API $api;

    private string $chat;

    public function __construct(
        int $apiId,
        string $apiHash
    ) {
        $this->settings = new Settings();
        $this->settings->merge(
            (new AppInfo())
            ->setApiId($apiId)
            ->setApiHash($apiHash)
        );
        $this->settings->merge($this->loggerSettings());
    }

    public function credential(string $credentialName = ''): Credible
    {
        if (!isset($this->credentials[$credentialName])) {
            return $this->credential;
        }
        return $this->credentials[$credentialName];
    }

    public function authorize(array $credentials): self
    {
        $this->credentials = $credentials;
        return $this;
    }

    public function as(string $credentialName): self
    {
        $this->credential = $this->credentials[$credentialName];
        try {
            $this->api = new API(
                $this->sessionDirectory($this->credential->sessionName()),
                $this->settings
            );
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
        $this->enter();
        return $this;
    }

    public function openChat(string $name): self
    {
        $this->chat = $name;
        return $this;
    }

    public function sendMessage(string $message): self
    {
        $this->api->sendMessage($this->chat, $message);
        return $this;
    }

    public function sendCommand(string $command): self
    {
        $this->api->sendMessage($this->chat, self::COMMAND_PREFIX . $command);
        return $this;
    }

    public function sendContact(
        string $phoneNumber,
        string $firstName,
        string $lastName,
        string $vcard,
    ): self {
        $media = [
            '_'            => 'inputMediaContact',
            'phone_number' => $phoneNumber,
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'vcard'        => $vcard,
        ];
        $this->api->messages->sendMedia(
            peer:  $this->chat,
            media: $media,
        );
        return $this;
    }

    public function sendOwnContact(): self
    {
        $this->sendContact(
            $this->credential->phone(),
            $this->credential->firstName(),
            $this->credential->lastName(),
            '',
        );
        return $this;
    }

    public function clickButton(string $title): self
    {
        $rows = $this->getLastMessageArray()['reply_markup']['rows'] ?? [];
        $data = null;
        foreach ($rows as $row) {
            if (
                ($currentButtonTitle = $row['buttons'][0]['text'] ?? '')
                && $currentButtonTitle === $title
            ) {
                /** @var Bytes|null $data */
                $data = $row['buttons'][0]['data'] ?? null;
                break;
            }
        }
        if (!$data) {
            throw new \Exception("Button with title '$title' was not found!");
        }
        try {
            $this->api->messages->getBotCallbackAnswer(
                game:   false,
                peer:   $this->chat,
                msg_id: $this->getLastMessageObject()->id,
                data:   (string)$data,
            );
        } catch (RPCErrorException $exception) {
            if ($exception->rpc === 'BOT_RESPONSE_TIMEOUT') {
                return $this;
            }
        }
        return $this;
    }

    public function wait(int $seconds): self
    {
        sleep($seconds);
        return $this;
    }

    public function isLastMessageTextEquals(string $text): bool
    {
        return $text === $this->getLastMessageText();
    }

    public function isLastMessageHasDocument(): bool
    {
        /** @var array|null $document */
        $document = $this->getLastMessageArray()['media']['document'] ?? null;
        return !is_null($document);
    }

    public function isLastMessageHasContact(): bool
    {
        /** @var array|null $messageMediaContact */
        $messageMediaContact = $this->getLastMessageArray()['media'] ?? null;
        return
            !is_null($messageMediaContact)
            && $messageMediaContact['_'] === 'messageMediaContact'
        ;
    }

    private function getLastMessageText(): string
    {
        $messages = $this->api->messages->getHistory(
            peer: $this->chat,
            limit: 1,
            floodWaitLimit: 3000
        );
        return $messages['messages'][0]['message'] ?? '';
    }

    private function getLastMessageArray(): array
    {
        $messages = $this->api->messages->getHistory(
            peer:           $this->chat,
            limit:          1,
            floodWaitLimit: 3000,
        );
        return $messages['messages'][0] ?? [];
    }

    private function getLastMessageObject(): AbstractMessage
    {
        return $this->api->wrapMessage($this->getLastMessageArray());
    }

    private function sessionDirectory(string $sessionName): string
    {
        $base = 'telegram-session';
        return $base . DIRECTORY_SEPARATOR . $sessionName;
    }

    private function enter(): void
    {
        if ($this->api->getAuthorization() === API::LOGGED_IN) {
            return;
        }
        $this->api->phoneLogin($this->credential->phone());
        if ($this->api->getAuthorization() === API::WAITING_CODE) {
            $code = Tools::readLine('Please enter code: ');
            $this->api->completePhoneLogin($code);
        }
        if ($this->api->getAuthorization() === API::WAITING_PASSWORD) {
            $password = Tools::readLine('Please enter password: ');
            $this->api->complete2faLogin($password);
        }
        if ($this->api->getAuthorization() === API::WAITING_SIGNUP) {
            $this->api->completeSignup($this->credential->firstName(), $this->credential->lastName());
        }
    }

    private function loggerSettings(): SettingsAbstract
    {
        return (new SettingsLogger())
            ->setLevel(Logger::LEVEL_FATAL)
            ->setType(Logger::LOGGER_FILE)
            ->setExtra('MadelineProto.log')
            ->setMaxSize(50*1024*1024);
    }
}
