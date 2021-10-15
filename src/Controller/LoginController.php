<?php

namespace Yanntyb\App\Controller;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Yanntyb\App\Model\Classes\Manager\TokenManager;
use Yanntyb\App\Model\Classes\Manager\UserManager;
use Yanntyb\App\Model\Traits\RenderViewTrait;

class LoginController
{

    use RenderViewTrait;

    public function checkLog($name, $pass)
    {
        $user = (new UserManager)->checkLog($name,$pass);
        if($user){
            $this->logger->info("User connect",
                [
                    "user" => $name,
                ]);
            return $user;
        }
        $this->logger->info("User try to connect ",
            [
                "user" => $name,
            ]);
        return false;
    }

    /**
     * Send registration token to specified mail
     * @param $mail
     * @return string[]
     * @throws Exception
     */
    public function sendToken($mail)
    {
        $manager = new TokenManager();
        $result = $manager->createToken($mail);
        if(!is_string($result)){
            $this->logger->info("New token send",
                [
                    "mail" => $mail,
                ]);
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