<?php

class Doctor extends User
{

    private string $drNumber;

    public function __construct(string $drNumber, string $firstname, string $surname, string $email, string $password, $role_id)
    {
        $this->drNumber  = $drNumber;
        parent::__construct($firstname, $surname, $email, $password, $role_id);
    }

    /**
     * @return string
     */
    public function getDrNumber(): string
    {
        return $this->drNumber;
    }


}