<?php

namespace TelegramTester;

class Human implements Credible, Nick
{
    private string $nick;
    private string $phone;
    private string $first;
    private string $last;

    public function __construct(string $commaSeparatedString) {
        $commaSeparatedArray = explode(',', $commaSeparatedString);
        $this->nick  = $commaSeparatedArray[0];
        $this->phone = $commaSeparatedArray[1];
        $this->first = $commaSeparatedArray[2];
        $this->last  = $commaSeparatedArray[3];
    }

    public function nick(): string
    {
        return $this->nick;
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function first(): string
    {
        return $this->first;
    }

    public function last(): string
    {
        return $this->last;
    }

    public function session(): string
    {
        return $this->last . '-' . $this->first;
    }
}
