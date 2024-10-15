<?php

namespace TelegramTester;

interface Credible
{
    public function session(): string;
    public function phone(): string;
    public function first(): string;
    public function last(): string;
}
