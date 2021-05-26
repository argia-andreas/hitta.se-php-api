<?php

namespace Grafstorm\Hitta;

use Grafstorm\Hitta\Enums\SearchType;
use Grafstorm\Hitta\Exceptions\HittaApiException;

class Hitta
{
    private SearchQuery $searchQuery;
    private Client $client;
    protected $baseUrl = 'https://api.hitta.se/publicsearch/v1/';
    private string $callerId;
    private string $apiKey;

    public function __construct(string $callerId, string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->callerId = $callerId;
        $random = bin2hex(random_bytes(8));
        $timestamp = time();

        $hash = hash('sha256', $this->callerId . $timestamp . $this->apiKey . $random);

        // Instantiate new Guzzle Client
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'hitta-callerid' => $this->callerId,
                'hitta-time' => $timestamp,
                'hitta-random' => $random,
                'hitta-hash' => $hash,
            ],
        ]);

        $this->searchQuery = new SearchQuery(SearchType::combined());
    }

    public function combined(): self
    {
        $this->searchQuery = new SearchQuery(SearchType::combined());

        return $this;
    }

    public function people(): self
    {
        $this->searchQuery = new SearchQuery(SearchType::people());

        return $this;
    }

    public function companies(): self
    {
        $this->searchQuery = new SearchQuery(SearchType::companies());

        return $this;
    }

    public function what($what): self
    {
        $this->searchQuery->what($what);

        return $this;
    }

    public function where($where): self
    {
        $this->searchQuery->where($where);

        return $this;
    }

    public function pageNumber($pageNumber = 0): self
    {
        $this->searchQuery->pageNumber($pageNumber);

        return $this;
    }

    public function pageSize($pageSize = 25): self
    {
        $this->searchQuery->pageSize($pageSize);

        return $this;
    }

    public function rangeFrom($rangeFrom = 0): self
    {
        $this->searchQuery->rangeFrom($rangeFrom);

        return $this;
    }

    public function rangeTo($rangeTo = 100): self
    {
        $this->searchQuery->rangeTo($rangeTo);

        return $this;
    }

    public function find(): HittaResult
    {
        if (! isset($this->searchQuery)) {
            throw HittaApiException::UninitializedSearchQuery();
        }

        return $this->client->find($this->searchQuery);
    }

    public function findPerson(string $personId): HittaDetailResult
    {
        $this->searchQuery = new SearchQuery(SearchType::personDetail());
        $this->searchQuery->detailId($personId);

        return $this->client->findDetail($this->searchQuery);
    }

    public function findCompany($companyId): HittaDetailResult
    {
        $this->searchQuery = new SearchQuery(SearchType::companyDetail());
        $this->searchQuery->detailId($companyId);

        return $this->client->findDetail($this->searchQuery);
    }
}
