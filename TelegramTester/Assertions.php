<?php

namespace TelegramTester;

trait Assertions
{
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
}
