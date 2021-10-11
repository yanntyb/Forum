<?php

class CommentController
{

    public function delete($id, $user){
        if((new CommentManager)->getSingleEntity($id)->getUser()->getId() === $user->getId() || $user->getRole() === "admin" || $user->getRole() === "mode"){
            (new CommentManager)->delete($id);
        }
    }
}