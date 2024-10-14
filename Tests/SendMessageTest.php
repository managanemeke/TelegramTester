<?php

namespace Tests;

final class SendMessageTest extends Test
{
    public function test(): void
    {
        self::tester()
            ->as(self::USER_A)
            ->openChat(self::USER_B)
            ->sendCommand('test')
            ->wait(1)
        ;
        $this->assertLastMessageTextEquals('test');
    }
}
