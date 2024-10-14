<?php

namespace TelegramTester;

class Credential implements Credible
{
    public function __construct(
        private string $lastName,
        private string $firstName,
        private string $phone,
        private string $sessionName,
    ) {
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function sessionName(): string
    {
        return $this->sessionName;
    }
}
