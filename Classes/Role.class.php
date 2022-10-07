<?php
declare(strict_types = 1);

class Role
{
    private int $role_id;
    private string $roleType;
    
    public const DOCTOR = 'DR';
    public const ADMIN = 'ADMIN';
    public const BOTH = 'BOTH';

    public function __construct(int $role_id, string $role_type)
    {
        $this->role_id = $role_id;
        $this->role_type = $role_type;
    }

    /**
     * @return string
     */
    public function getRoleType(): string
    {
        return $this->role_type;
    }
    
    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->role_id;
    }

}