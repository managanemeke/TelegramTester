<?php

namespace Tests;

final class SendMessageTest extends Test
{
    public function test(): void
    {
        self::tester()
            ->as(self::human())
            ->openChat(self::bot())
            ->sendMessage('test')
            ->wait(1)
        ;
        $this->assertLastMessageTextEquals('test');
    }
}
