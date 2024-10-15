<?php

namespace Tests;

use TelegramTester\Bot;
use TelegramTester\Credible;
use TelegramTester\Human;

class Credentials
{
    /**
     * @return Credible[]
     */
    public static function credentials(): array
    {
        return [
            self::human()->nick() => self::human(),
        ];
    }

    public static function apiId(): string
    {
        return $_ENV['API_ID'];
    }

    public static function apiHash(): string
    {
        return $_ENV['API_HASH'];
    }

    public static function human(): Human
    {
        return new Human($_ENV['HUMAN']);
    }

    public static function bot(): Bot
    {
        return new Bot($_ENV['BOT']);
    }
}
