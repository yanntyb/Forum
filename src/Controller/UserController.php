<?php

namespace Yanntyb\App\Controller;

use Yanntyb\App\Model\Classes\Manager\UserManager;

class UserController
{

    public function delete($id){
        $user = (new UserManager)->getSingleEntity($id);
        $connected = unserialize($_SESSION["user"]);
        if($user->getId() !== $connected->getId() && $connected->getRole()->getName() === "admin"){
            (new UserManager)->delete($id);
        }
    }
}