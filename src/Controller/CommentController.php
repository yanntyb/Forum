<?php

namespace Yanntyb\App\Controller;

use Yanntyb\App\Model\Classes\Manager\CommentManager;
use Yanntyb\App\Model\Traits\RenderViewTrait;

class CommentController
{
    use RenderViewTrait;

    public function delete($id, $user){
        $comment = (new CommentManager)->getSingleEntity($id);
        if($comment->getUser()->getId() === $user->getId() || $user->getRole() === "admin" || $user->getRole() === "mode"){
            (new CommentManager)->delete($id);
            $this->logger->info("Comment deleted",
                [
                    "title" => $comment->getContent(),
                    "user" => $user->getName(),
                    "user role" => $user->getRole()->getName()
                ]);
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