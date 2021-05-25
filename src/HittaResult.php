<?php


namespace Grafstorm\Hitta;


use Grafstorm\Hitta\Exceptions\HittaApiException;
use Psr\Http\Message\ResponseInterface;

class HittaResult
{
    private $result;
    public $totalPeople;
    public $includedPeople;
    public $totalCompanies;
    public $includedCompanies;
    public $people;
    public $companies;


    public function __construct($people, $includedPeople, $totalPeople, $companies, $includedCompanies, $totalCompanies)
    {
        $this->includedPeople = $includedPeople;
        $this->totalPeople = $totalPeople;
        $this->includedCompanies = $includedCompanies;
        $this->totalCompanies = $totalCompanies;
        $this->companies = $companies;
        $this->people = $people;
    }

    public static function fromResponse(ResponseInterface $response): HittaResult
    {
        if (! ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300)) {
            throw HittaApiException::ResponseCode($response->getStatusCode());
        }

        $json = json_decode($response->getBody());
        $people = $json->result->persons?->person ?? null;
        $includedPeople = $json->result->persons?->included ?? null;
        $totalPeople = $json->result->persons?->total ?? null;
        $companies = $json->result->companies?->company ?? null;
        $includedCompanies = $json->result->companies?->included ?? null;
        $totalCompanies = $json->result->companies?->total ?? null;
        return new static(
            $people,
            $includedPeople,
            $totalPeople,
            $companies,
            $includedCompanies,
            $totalCompanies
        );
    }
}
