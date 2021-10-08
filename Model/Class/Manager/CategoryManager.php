<?php

use Controller\Traits\GlobalManagerTrait;

class CategoryManager
{
    use GlobalManagerTrait;

    /**
     * Delete a category
     * @param int $catId
     */
    public function delete(int $catId){
        $conn = $this->db->prepare("DELETE FROM category WHERE id = :id");
        $conn->bindValue(":id", $catId);
        $conn->execute();
    }

    /**
     * Create a new category
     * @param string $title
     * @param $content
     * @return bool
     */
    public function publish(string $title, $content): bool
    {
        $conn = $this->db->prepare("INSERT INTO category (name, description) VALUES (:name, :desc)");
        $conn->bindValue(":name", $this->sanitize($title));
        $conn->bindValue(":desc",$this->sanitize($content));
        if($conn->execute()){
            return true;
        }
        return false;
    }
}