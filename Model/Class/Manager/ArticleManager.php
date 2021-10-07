<?php

use Controller\Traits\GlobalManagerTrait;

class ArticleManager
{
    use GlobalManagerTrait;

    /**
     * Insert a new Article in BDD
     * @param $title
     * @param $content
     * @param $category
     * @param $userId
     */
    public function publish($title, $content, $category, $userId)
    {
        $conn = $this->db->prepare("INSERT INTO article (title, content, category_fk, user_fk, date) VALUES (:title, :content, :category, :user, :date)");
        $conn->bindValue(":title", $this->sanitize(substr($title,0,110)));
        $conn->bindValue(":content", $this->sanitize($content));
        $conn->bindValue(":category", $this->sanitize($category));
        $conn->bindValue(":user",$this->sanitize($userId));
        $conn->bindValue(":date",date("d/m/Y H:m:s"));
        if($conn->execute()){
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Delete article from data base based on his id
     * @param $articleId
     * @return bool
     */
    public function deleteById($articleId): bool
    {
        $conn = $this->db->prepare("DELETE FROM article WHERE id = :id");
        $conn->bindValue(":id",$articleId);
        if($conn->execute()){
            return true;
        }
        return false;
    }
}