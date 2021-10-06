<?php

class LoginController
{

    public function checkLog($name, $pass){
        return (new UserManager)->checkLog($name,$pass);
    }

    public function sendToken($mail){
        $manager = new TokenManager();
        $result = $manager->createToken($mail);
        if(!is_string($result)){
            return ["message" => "Un lien d'inscription vous a été envoyé a l'adresse " . $manager->sanitize($mail)];
        }
        else{
            return ["message" => $result];
        }
    }

}