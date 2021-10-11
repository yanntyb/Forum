<?php

use Controller\Traits\RenderViewTrait;

class CommentController
{
    use RenderViewTrait;

    public function delete($id, $user){
        if((new CommentManager)->getSingleEntity($id)->getUser()->getId() === $user->getId() || $user->getRole() === "admin" || $user->getRole() === "mode"){
            (new CommentManager)->delete($id);
        }
    }

    public function edit($comment){
        $this->render("Comment/edit", "Editer le commentaire de  " . $comment->getUser()->getName(), $comment);
    }

    public function editContent($comment, $user, $content, $id){
        if($comment->getUser()->getId() === $user->getId() || $user->getRole()->getName() === "admin" || $user->getRole()->getName() === "mode"){
            (new CommentManager)->edit($content, $id, $user);
        }
    }
}