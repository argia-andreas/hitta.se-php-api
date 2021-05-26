<?php

namespace Grafstorm\Hitta;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class Client extends GuzzleClient
{
    public function find(SearchQuery $searchQuery): HittaResult
    {
        try {
            $response = $this->get($searchQuery->toUri(), [
                'query' => $searchQuery->query(),
            ]);

            return HittaResult::fromResponse($response);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    public function findDetail(SearchQuery $searchQuery): HittaDetailResult
    {
        try {
            $response = $this->get($searchQuery->toUri(), [
                'query' => $searchQuery->query(),
            ]);

            return HittaDetailResult::fromResponse($response);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
}
