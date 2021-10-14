<?php

namespace Yanntyb\App\Controller;

use Exception;
use Yanntyb\App\Model\Classes\Manager\TokenManager;
use Yanntyb\App\Model\Classes\Manager\UserManager;

class LoginController
{

    public function checkLog($name, $pass)
    {
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

    /**
     * Check Token then create a new User then remove Token from database
     * @param $token
     */
    public function checkToken($token){
        $tokenCheck = (new TokenManager)->getSingleEntity($token,"token");
        if($tokenCheck){
            if((new UserManager)->insertUser($tokenCheck->getMail())){
                (new TokenManager)->removeToken($tokenCheck->getId());
                return $tokenCheck->getMail();
            }
            return false;
        }
        return false;
    }


}