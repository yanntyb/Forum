<?php

class LoginController
{

    public function checkLog($name, $pass){
        return (new UserManager)->checkLog($name,$pass);
    }

    /**
     * Send registration token to specified mail
     * @param $mail
     * @return string[]
     * @throws Exception
     */
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

    public function checkToken($token){
        $tokenCheck = (new TokenManager)->getSingleEntity("token",$token);
        if($tokenCheck){
            (new UserManager)->insertUser($tokenCheck->getMail(),"mail","pass");
        }
    }

}