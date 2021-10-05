<?php

class LoginController
{

    public function checkLog($name, $pass){
        return (new UserManager)->checkLog($name,$pass);
    }
}