<?php

namespace TelegramTester;

class Bot implements Nick
{
    private string $nick;
    private string $token;

    public function __construct(string $commaSeparatedString) {
        $commaSeparatedArray = explode(',', $commaSeparatedString);
        $this->nick  = $commaSeparatedArray[0];
        $this->token = $commaSeparatedArray[1];
    }

    public function nick(): string
    {
        return $this->nick;
    }

    public function token(): string
    {
        return $this->token;
    }
}
