<?php

namespace App\Services\DTO;

class RfmDTO
{
    /** @var integer */
    public $userId;

    /** @var array  */
    public $rfmTable = [];

    /** @var array  */
    public $classification = [];

    /**
     * @param array $table
     */
    public function setRfmTable(array $table): void
    {
        $this->rfmTable = $table;
    }

    /**
     * @return array
     */
    public function getRfmTable(): array
    {
        return $this->rfmTable;
    }

    /**
     * @param array $classification
     */
    public function setClassification(array $classification): void
    {
        $this->classification = $classification;
    }

    /**
     * @return array
     */
    public function getClassification(): array
    {
        return $this->classification;
    }
}