<?php

use Controller\Traits\GlobalEntityTrait;

class User
{
    use GlobalEntityTrait;

    private string $name;
    private string $pass;
    private Role $role;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     * @return $this
     */
    public function setPass(string $pass): User
    {
        $this->pass = $pass;
        return $this;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     * @return $this
     */
    public function setRole(Role $role): User
    {
        $this->role = $role;
        return $this;
    }


}