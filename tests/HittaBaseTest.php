<?php

namespace Grafstorm\Hitta\Tests;

use PHPUnit\Framework\TestCase;
use Grafstorm\Hitta\Hitta;

class HittaBaseTest extends TestCase
{
    /** @test */
    public function init_works()
    {
        $apiKey = $_ENV['HITTA_API_KEY'];
        $callerId = $_ENV['HITTA_CALLER_ID'];

        $hitta = new Hitta($apiKey, $callerId);

        $this->assertInstanceOf(Hitta::class, $hitta);
    }
}
