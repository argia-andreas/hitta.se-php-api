<?php


namespace Grafstorm\Hitta;

use Grafstorm\Hitta\Enums\SearchType;

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
        $this->options['what'] = $what;
        return $this;
    }

    public function where($where): self
    {
        $this->options['where'] = $where;
        return $this;
    }

    public function pageNumber($pageNumber): self
    {
        $this->options['page.number'] = $pageNumber;
        return $this;
    }

    public function pageSize($pageSize): self
    {
        $this->options['page.size'] = $pageSize;
        return $this;
    }

    public function rangeFrom($rangeFrom): self
    {
        $this->options['range.from'] = $rangeFrom;
        return $this;
    }

    public function rangeTo($rangeTo): self
    {
        $this->options['range.to'] = $rangeTo;
        return $this;
    }

    public function findDetail($detailId)
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
            $this->uri = "person/".$this->detailId.".json?";
        }

        if ($this->searchType === (string) SearchType::companyDetail()) {
            $this->uri = "company/".$this->detailId.".json?";
        }

        return $this->uri;
    }

    public function query()
    {
        return $this->options;
    }

}
