<?php

namespace TelegramTester;

interface Credible
{
    public function sessionName(): string;
    public function phone(): string;
    public function firstName(): string;
    public function lastName(): string;
}
