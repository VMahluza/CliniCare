<?php

require_once './Includes/autoload.inc.php';

class Patient extends Person
{
    public ?Diagnosis $diagnosis;

    private string $patientNumber;


    public function __construct(int $id, string $patientNumber ,string $firstname, string $surname, $created)
    {
        parent::__construct( $id,  $firstname,  $surname, $created);
        $this->patientNumber = $patientNumber;

    }

    /**
     * @return Diagnosis
     */
    public function getDiagnosis(): array
    {
        return $this->diagnosis;
    }

    /**
     * @param string $patientNumber
     */
    public function setPatientNumber(string $patientNumber): void
    {
        $this->patientNumber = $patientNumber;
    }

    /**
     * @return string
     */
    public function getPatientNumber(): string
    {
        return $this->patientNumber;
    }

}