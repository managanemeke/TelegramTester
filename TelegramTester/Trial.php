<?php

namespace TelegramTester;

interface Trial
{
    public function credential(string $credentialName = ''): Credible;
    /**
     * @param Credible[] $credentials
     */
    public function authorize(array $credentials): self;
    public function as(string $credentialName): self;
    public function openChat(string $name): self;
    public function sendMessage(string $message): self;
    public function sendCommand(string $command): self;
    public function clickButton(string $title): self;
    public function wait(int $seconds): self;
    public function isLastMessageTextEquals(string $text): bool;
    public function isLastMessageHasDocument(): bool;
}
