<?php

namespace Yanntyb\App\Model\Classes\Entity;

use Yanntyb\App\Model\Traits\GlobalEntityTrait;

/**
 * Class used for register new user
 */
class Token
{
    use GlobalEntityTrait;

    private string $token;
    private string $mail;
    private int $date;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token): Token
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     * @return $this
     */
    public function setMail(string $mail): Token
    {
        $this->mail = $mail;
        return $this;
    }


    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

    /**
     * @param int $date
     * @return $this
     */
    public function setDate(int $date): Token
    {
        $this->date = $date;
        return $this;
    }



}