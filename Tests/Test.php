<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use TelegramTester\Tester;
use TelegramTester\Trial;

abstract class Test extends TestCase
{
    protected const USER_A = Credentials::USER_A;
    protected const USER_B = Credentials::USER_B;
    protected const API_ID = Credentials::API_ID;
    protected const API_HASH = Credentials::API_HASH;

    private static Trial $tester;

    public static function setUpBeforeClass(): void
    {
        self::$tester = (new Tester(
                self::API_ID,
                self::API_HASH,
            ))
            ->authorize(Credentials::credentials())
        ;
    }

    public static function tester(): Trial
    {
        return self::$tester;
    }

    protected function assertLastMessageTextEquals(string $text): void
    {
        $this->assertTrue(self::$tester->isLastMessageTextEquals($text));
    }

    protected function assertLastMessageHasDocument(): void
    {
        $this->assertTrue(self::$tester->isLastMessageHasDocument());
    }
}
