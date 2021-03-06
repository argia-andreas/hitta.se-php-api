<?php

namespace Grafstorm\Hitta\Tests;

use Grafstorm\Hitta\Exceptions\HittaApiException;
use Grafstorm\Hitta\Hitta;
use Grafstorm\Hitta\HittaDetailResult;
use Grafstorm\Hitta\HittaResult;
use PHPUnit\Framework\TestCase;

class HittaBaseTest extends TestCase
{
    /** @test */
    public function init_works()
    {
        $apiKey = '::api-key::';
        $callerId = '::caller-id::';

        $hitta = new Hitta($callerId, $apiKey);

        $this->assertInstanceOf(Hitta::class, $hitta);
    }

    /** @test */
    public function basic_combined_search()
    {
        if (! (isset($_ENV['HITTA_API_KEY']) && isset($_ENV['HITTA_CALLER_ID']))) {
            $this->markTestSkipped();

            return;
        }

        $apiKey = $_ENV['HITTA_API_KEY'];
        $callerId = $_ENV['HITTA_CALLER_ID'];

        $hitta = new Hitta($callerId, $apiKey);
        $result = $hitta->what('Hitta')->find();

        $this->assertInstanceOf(HittaResult::class, $result);
    }

    /** @test */
    public function basic_company_search()
    {
        if (! (isset($_ENV['HITTA_API_KEY']) && isset($_ENV['HITTA_CALLER_ID']))) {
            $this->markTestSkipped();

            return;
        }
        $apiKey = $_ENV['HITTA_API_KEY'];
        $callerId = $_ENV['HITTA_CALLER_ID'];

        $hitta = new Hitta($callerId, $apiKey);
        $result = $hitta->companies()->what('Hitta')->find();

        $this->assertInstanceOf(HittaResult::class, $result);
    }

    /** @test */
    public function basic_people_search()
    {
        if (! (isset($_ENV['HITTA_API_KEY']) && isset($_ENV['HITTA_CALLER_ID']))) {
            $this->markTestSkipped();

            return;
        }
        $apiKey = $_ENV['HITTA_API_KEY'];
        $callerId = $_ENV['HITTA_CALLER_ID'];

        $hitta = new Hitta($callerId, $apiKey);
        $result = $hitta->people()->what('Hitta')->find();

        $this->assertInstanceOf(HittaResult::class, $result);
    }

    /** @test */
    public function basic_people_detail_search()
    {
        if (! (isset($_ENV['HITTA_API_KEY']) && isset($_ENV['HITTA_CALLER_ID']))) {
            $this->markTestSkipped();

            return;
        }
        $apiKey = $_ENV['HITTA_API_KEY'];
        $callerId = $_ENV['HITTA_CALLER_ID'];

        $hitta = new Hitta($callerId, $apiKey);
        $result = $hitta->findPerson('::person-id::');

        $this->assertInstanceOf(HittaDetailResult::class, $result);
    }

    /** @test */
    public function basic_company_detail_search()
    {
        if (! (isset($_ENV['HITTA_API_KEY']) && isset($_ENV['HITTA_CALLER_ID']))) {
            $this->markTestSkipped();

            return;
        }
        $apiKey = $_ENV['HITTA_API_KEY'];
        $callerId = $_ENV['HITTA_CALLER_ID'];

        $hitta = new Hitta($callerId, $apiKey);
        $result = $hitta->findCompany('::company-id::');

        $this->assertInstanceOf(HittaDetailResult::class, $result);
    }

    /** @test */
    public function expanded_company_search()
    {
        if (! (isset($_ENV['HITTA_API_KEY']) && isset($_ENV['HITTA_CALLER_ID']))) {
            $this->markTestSkipped();

            return;
        }
        $apiKey = $_ENV['HITTA_API_KEY'];
        $callerId = $_ENV['HITTA_CALLER_ID'];

        $hitta = new Hitta($callerId, $apiKey);
        $result = $hitta->companies('::company::')
            ->where('::where::')
            ->pageNumber(1)
            ->pageSize(10)
            ->rangeFrom(5)
            ->rangeTo(10)
            ->find();

        $this->assertInstanceOf(HittaResult::class, $result);
    }

    /** @test */
    public function expanded_person_search()
    {
        if (! (isset($_ENV['HITTA_API_KEY']) && isset($_ENV['HITTA_CALLER_ID']))) {
            $this->markTestSkipped();

            return;
        }
        $apiKey = $_ENV['HITTA_API_KEY'];
        $callerId = $_ENV['HITTA_CALLER_ID'];

        $hitta = new Hitta($callerId, $apiKey);
        $result = $hitta->companies('::person::')
            ->where('::where::')
            ->pageNumber(1)
            ->pageSize(10)
            ->rangeFrom(5)
            ->rangeTo(10)
            ->find();

        $this->assertInstanceOf(HittaResult::class, $result);
    }

    /** @test */
    public function empty_search()
    {
        $this->expectException(HittaApiException::class);
        $apiKey = '::key::';
        $callerId = '::id::';

        $hitta = new Hitta($callerId, $apiKey);
        $result = $hitta->find();
    }
}
