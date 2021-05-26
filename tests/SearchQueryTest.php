<?php

namespace Grafstorm\Hitta\Tests;

use ArgumentCountError;
use Grafstorm\Hitta\Enums\SearchType;
use Grafstorm\Hitta\Exceptions\HittaApiException;
use Grafstorm\Hitta\SearchQuery;
use PHPUnit\Framework\TestCase;

class SearchQueryTest extends TestCase
{
    /** @test */
    public function fails_without_type()
    {
        $this->expectException(ArgumentCountError::class);
        $hitta = new SearchQuery();
    }

    /** @test */
    public function combined_search_type()
    {
        $searchQuery = new SearchQuery(SearchType::combined());
        $this->assertEquals('combined.json?', $searchQuery->toUri());
    }

    /** @test */
    public function people_search_type()
    {
        $searchQuery = new SearchQuery(SearchType::people());
        $this->assertEquals('persons.json?', $searchQuery->toUri());
    }

    /** @test */
    public function company_search_type()
    {
        $searchQuery = new SearchQuery(SearchType::companies());
        $this->assertEquals('companies.json?', $searchQuery->toUri());
    }

    /** @test */
    public function company_find_type()
    {
        $searchQuery = new SearchQuery(SearchType::companyDetail());
        $searchQuery->detailId('::ID::');
        $this->assertEquals('company/::ID::.json?', $searchQuery->toUri());
    }

    /** @test */
    public function person_find_type()
    {
        $searchQuery = new SearchQuery(SearchType::personDetail());
        $searchQuery->detailId('::ID::');
        $this->assertEquals('person/::ID::.json?', $searchQuery->toUri());
    }

    /** @test */
    public function full_query_options()
    {
        $searchQuery = new SearchQuery(SearchType::companies());
        $searchQuery->what('::what::');
        $searchQuery->where('::where::');
        $searchQuery->pageNumber(1);
        $searchQuery->pageSize(1);
        $searchQuery->rangeFrom(1);
        $searchQuery->rangeTo(10);

        $options = $searchQuery->query();

        $this->assertArrayHasKey('what', $options);
        $this->assertArrayHasKey('where', $options);
        $this->assertArrayHasKey('page.number', $options);
        $this->assertArrayHasKey('page.size', $options);
        $this->assertArrayHasKey('range.from', $options);
        $this->assertArrayHasKey('range.to', $options);
    }

    /** @test */
    public function exception_on_detail_when_no_deatil_id()
    {
        $this->expectException(HittaApiException::class);
        $searchQuery = new SearchQuery(SearchType::personDetail());
        $searchQuery->toUri();
    }

    /** @test */
    public function exception_on_invalid_methods_when_deatil_search()
    {
        $this->expectException(HittaApiException::class);
        $searchQuery = new SearchQuery(SearchType::personDetail());
        $searchQuery->what('::what::');
    }
}
