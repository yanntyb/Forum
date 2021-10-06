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
     * @return bool
     */
    public function publish($title, $content, $category, $userId): bool
    {
        $conn = $this->db->prepare("INSERT INTO article (title, content, category_fk, user_fk) VALUES (:title, :content, :category, :user)");
        $conn->bindValue(":title", $this->sanitize($title));
        $conn->bindValue(":content", $this->sanitize($content));
        $conn->bindValue(":category", $this->sanitize($category));
        $conn->bindValue(":user",$this->sanitize($userId));
        if($conn->execute()){
            return true;
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