<?php

namespace Models;
class Diagnosis
{

    public int $Diagnosis_id;
    public string $title;
    public string $description;
    public ?Notes $notes; //array
    public string $date;

    public function __construct(int $Diagnosis_id,
                                string $title,
                                string $description,
                                $date)
    {
        $this->Diagnosis_id = $Diagnosis_id;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->notes = null;
    }

    /**
     * @return int
     */
    public function getDiagnosisId(): int
    {
        return $this->Diagnosis_id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return Notes|null
     */
    public function getNotes(): array
    {
        return $this->notes;
    }

}

