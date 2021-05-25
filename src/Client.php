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
                'query' => $searchQuery->query()
            ]);
            return HittaResult::fromResponse($response);
        } catch (GuzzleException $e) {
            logger($e->getMessage());
            throw $e;
            // TODO - Some error here.
        }
    }

    public function findDetail(SearchQuery $searchQuery): HittaDetailResult
    {
        try {
            $response = $this->get($searchQuery->toUri(), [
                'query' => $searchQuery->query()
            ]);
            return HittaDetailResult::fromResponse($response);
        } catch (GuzzleException $e) {
            logger($e->getMessage());
            throw $e;
            // TODO - Some error here.
        }
    }
}
