<?php

namespace Yanntyb\App\Controller;

use Yanntyb\App\Model\Classes\Entity\User;
use Yanntyb\App\Model\Classes\Manager\UserManager;
use Yanntyb\App\Model\Traits\RenderViewTrait;

class ProfileController
{
    use RenderViewTrait;

    public function editProfile(User $user){
        $this->render("Profile/edit","Edition du profile",$user);
    }

    public function changePass(string $newPass,User $user){
        (new UserManager)->changePass($newPass,$user->getId());
    }

    public function changeName(string $newName, User $user){
        (new UserManager)->changeName($newName, $user->getId());
    }
}