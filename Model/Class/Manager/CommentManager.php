<?php

use Controller\Traits\GlobalManagerTrait;

class CommentManager
{
    use GlobalManagerTrait;

    public function getArticleComment(int $id): array
    {
        $conn = $this->db->prepare("SELECT id FROM comment WHERE article_fk = :id");
        $conn->bindValue(":id", $id);
        $conn->execute();
        $result = $conn->fetchAll();
        $return = [];
        foreach($result as $comment){
            $return[] = $this->getSingleEntity($comment["id"]);
        }
        return $return;
    }
}