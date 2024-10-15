<?php

namespace Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use TelegramTester\Tester;
use TelegramTester\Trial;

abstract class Test extends TestCase
{
    private static Trial $tester;

    public static function setUpBeforeClass(): void
    {
        self::loadEnvironment();
        self::$tester = (new Tester(
                Credentials::apiId(),
                Credentials::apiHash(),
            ))
            ->authorize(Credentials::credentials())
        ;
    }

    protected static function tester(): Trial
    {
        return self::$tester;
    }

    protected static function human(): string
    {
        return Credentials::human()->nick();
    }

    protected static function bot(): string
    {
        return Credentials::bot()->nick();
    }

    protected function assertLastMessageTextEquals(string $text): void
    {
        $this->assertTrue(self::$tester->isLastMessageTextEquals($text));
    }

    protected function assertLastMessageHasDocument(): void
    {
        $this->assertTrue(self::$tester->isLastMessageHasDocument());
    }

    protected function assertLastMessageHasContact(): void
    {
        $this->assertTrue(self::$tester->isLastMessageHasContact());
    }

    private static function loadEnvironment(): void
    {
        $dotenv = Dotenv::createImmutable(
            realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
            '.env',
        );
        $dotenv->safeLoad();
    }
}
