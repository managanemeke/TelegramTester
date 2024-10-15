<?php

namespace Tests;

final class SendContactTest extends Test
{
    public function test(): void
    {
        self::tester()
            ->as(self::human())
            ->openChat(self::bot())
            ->sendOwnContact()
            ->wait(1)
        ;
        $this->assertLastMessageHasContact();
    }
}
