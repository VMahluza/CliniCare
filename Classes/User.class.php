<?php

declare(strict_types = 1);
require_once './Includes/autoload.inc.php';
class User extends Person{

    private string $email;
    private string $password;
    private int $role_id;
    const DR = 1;
    const ADMIN = 2;
    //private Role $role;

    public function __construct(string $firstname, string $surname, string $email, string $password, $role_id) {
        parent::__construct($firstname, $surname);
        $this->role_id = $role_id;      
    }
    
    function getRoleId():int {
        return $this->role_id;
    }

    public function getEmail():string{

        return $this->email;
    }
    public function getPassword():string{

        return $this->password;
    }

}

?>




