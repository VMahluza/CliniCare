<?php
declare(strict_types = 1);
namespace Models;

class Person
{

    private int $id;
    private string $firstname;
    private string $surname;
    private string $email;
    private string $password;

    public function __construct(int $id, string $firstname, string $surname)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->email = $this->email;
        $this->password = $this->password;
    }

}