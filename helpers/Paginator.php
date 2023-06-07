<?php
class Paginator
{
    public $perPage;
    private $currentPage;
    private $totalItems;

    public function __construct($perPage)
    {
        $this->perPage = $perPage;
        $this->currentPage = 1;
        $this->totalItems = 0;
    }

    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }

    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }

    public function getOffset()
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function getTotalPages()
    {
        return ceil($this->totalItems / $this->perPage);
    }
}
