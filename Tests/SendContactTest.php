<?php

namespace Tests;

final class SendContactTest extends Test
{
    public function test(): void
    {
        self::tester()
            ->as(self::USER_A)
            ->openChat(self::USER_B)
            ->sendOwnContact()
            ->wait(1)
        ;
        $this->assertLastMessageHasContact();
    }
}
