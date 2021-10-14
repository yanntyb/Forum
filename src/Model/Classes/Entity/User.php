<?php

namespace Yanntyb\App\Model\Classes\Entity;

use Yanntyb\App\Model\Traits\GlobalEntityTrait;

class User
{
    use GlobalEntityTrait;

    private string $name;
    private string $pass;
    private Role $role;
    private string $img;

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

    /**
     * @param string $img
     * @return $this*
     */
    public function setImg(string $img): User
    {
        $this->img = "View/_partials/user_pic/" . $img;
        return $this;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

}