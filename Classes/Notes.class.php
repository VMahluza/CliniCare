<?php
declare(strict_types = 1);

class Notes
{
    private int $notes_id;
    private string $notes;
    private int $Diagnosis_id;
    private $created;

    public function __construct(int $notes_id, string $notes, int $Diagnosis_id, $created)
    {
        $this->notes_id = $notes_id;
        $this->notes = $notes;
        $this->Diagnosis_id = $Diagnosis_id;
        $this->created = $created;
    }

    /**
     * @return int
     */
    public function getNotesId(): int
    {
        return $this->notes_id;
    }
    
    /**
     * @return string
     */
    public function getNotes(): string
    {
        return $this->notes;
    }

    /**
     * @return int
     */
    public function getDiagnosisId(): int
    {
        return $this->Diagnosis_id;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }
}