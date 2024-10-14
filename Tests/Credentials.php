<?php

namespace Tests;

use TelegramTester\Credential;

class Credentials
{
    public const USER_A = '@userA';
    public const USER_B = '@userB';
    public const API_ID = '23100846';
    public const API_HASH = '9e986fd5fr7a13a7dd6b3558c00c8b83';

    /**
     * @return Credential[]
     */
    public static function credentials(): array
    {
        return [
            self::USER_A => new Credential(
                'a',
                'user',
                '+71111111111',
                'a',
            ),
            self::USER_B => new Credential(
                'b',
                'user',
                '+72222222222',
                'b',
            ),
        ];
    }
}
