<?php


namespace Grafstorm\Hitta;

use Grafstorm\Hitta\Enums\SearchType;
use Grafstorm\Hitta\Exceptions\HittaApiException;

class SearchQuery
{
    private string $uri;
    private array $options;
    private string $searchType;
    private $detailId = null;

    public function __construct(string $searchType, $options = [])
    {
        $this->searchType = $searchType;
        $this->options = $options;
    }

    public function what($what): self
    {
        if ($this->searchType === (string) SearchType::personDetail() || $this->searchType === (string) SearchType::companyDetail()) {
            throw HittaApiException::InvalidMethod('Cant use this method on find detail.');
        }

        $this->options['what'] = $what;

        return $this;
    }

    public function where($where): self
    {
        if ($this->searchType === (string) SearchType::personDetail() || $this->searchType === (string) SearchType::companyDetail()) {
            throw HittaApiException::InvalidMethod('Cant use this method on find detail.');
        }

        $this->options['where'] = $where;

        return $this;
    }

    public function pageNumber($pageNumber): self
    {
        if ($this->searchType === (string) SearchType::personDetail() || $this->searchType === (string) SearchType::companyDetail()) {
            throw HittaApiException::InvalidMethod('Cant use this method on find detail.');
        }

        $this->options['page.number'] = $pageNumber;

        return $this;
    }

    public function pageSize($pageSize): self
    {
        if ($this->searchType === (string) SearchType::personDetail() || $this->searchType === (string) SearchType::companyDetail()) {
            throw HittaApiException::InvalidMethod('Cant use this method on find detail.');
        }

        $this->options['page.size'] = $pageSize;

        return $this;
    }

    public function rangeFrom($rangeFrom): self
    {
        if ($this->searchType === (string) SearchType::personDetail() || $this->searchType === (string) SearchType::companyDetail()) {
            throw HittaApiException::InvalidMethod('Cant use this method on find detail.');
        }

        $this->options['range.from'] = $rangeFrom;

        return $this;
    }

    public function rangeTo($rangeTo): self
    {
        if ($this->searchType === (string) SearchType::personDetail() || $this->searchType === (string) SearchType::companyDetail()) {
            throw HittaApiException::InvalidMethod('Cant use this method on find detail.');
        }

        $this->options['range.to'] = $rangeTo;

        return $this;
    }

    public function detailId($detailId)
    {
        $this->detailId = $detailId;
    }

    public function toUri(): string
    {
        if ($this->searchType === (string) SearchType::combined()) {
            $this->uri = 'combined.json?';
        }

        if ($this->searchType === (string) SearchType::companies()) {
            $this->uri = 'companies.json?';
        }

        if ($this->searchType === (string) SearchType::people()) {
            $this->uri = 'persons.json?';
        }

        if ($this->searchType === (string) SearchType::personDetail()) {
            if (! $this->detailId) {
                throw HittaApiException::NoDetailId();
            }

            $this->uri = "person/".$this->detailId.".json?";
        }

        if ($this->searchType === (string) SearchType::companyDetail()) {
            if (! $this->detailId) {
                throw HittaApiException::NoDetailId();
            }
            $this->uri = "company/".$this->detailId.".json?";
        }

        return $this->uri;
    }

    public function query()
    {
        return $this->options;
    }
}
