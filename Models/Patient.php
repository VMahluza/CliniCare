<?php

namespace Models;

class Patient extends Person
{
    public ?Diagnosis $diagnosis;
    /**
     * @return Diagnosis
     */
    public function getDiagnosis(): array
    {
        return $this->diagnosis;
    }

    /**
     * @param Diagnosis $diagnosis
     */
    public function add_diagnosis(Diagnosis $diagnosis): void
    {
        $this->diagnosis[] = $diagnosis;
    }

}