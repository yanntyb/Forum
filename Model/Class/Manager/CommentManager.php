<?php

use Controller\Traits\GlobalManagerTrait;

class CommentManager
{
    use GlobalManagerTrait;

    /**
     * Return an array of Comment Object relative to a specified article
     * @param int $id
     * @return array
     */
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

    /**
     * Insert a comment in database based on article's id and user's id
     * @param $content
     * @param $articleId
     * @param $userId
     */
    public function addComment($content, $articleId, $userId)
    {
        $conn = $this->db->prepare("INSERT INTO comment (content, user_fk, article_fk, date) VALUES (:content, :user, :article, :date)");
        $conn->bindValue(":content", $this->sanitize($content));
        $conn->bindValue(":user", $userId);
        $conn->bindValue(":article",$articleId);
        $conn->bindValue(":date", date("d/m/Y H:m:s"));
        if($conn->execute()) {
            return $this->db->lastInsertId();
        }
        return false;

    }
}