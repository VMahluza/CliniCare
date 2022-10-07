<?php
declare(strict_types = 1);

abstract class Person
{

    private int $id;
    private string $firstname;
    private string $surname;
    private $created;


    public function __construct(int $id, string $firstname, string $surname, $created)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->created = $created;
        
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getFirstName(): string {
        return $this->firstname;
    }
    
    public function getSurname():string
    {

        return $this->surname;

    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }


    
}

