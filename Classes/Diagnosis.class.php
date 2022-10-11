<?php

class Diagnosis
{

    private int $Diagnosis_id;
    private int $person_id;//FK
    private string $title;
    private string $description;
    private string $date;

    public function __construct(int $Diagnosis_id,int $person_id,
                                string $title,
                                string $description,
                                $date)
    {
        $this->Diagnosis_id = $Diagnosis_id;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->person_id = $person_id;
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
     * @return int
     */
    public function getPersonId(): int
    {
        return $this->person_id;
    }

}

