<?php

namespace Yanntyb\App\Model\Classes\Manager;

use Yanntyb\App\Model\Traits\GlobalManagerTrait;

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
    public function publish(string $title, string $content): bool
    {
        $conn = $this->db->prepare("INSERT INTO category (name, description) VALUES (:name, :desc)");
        $conn->bindValue(":name", $this->sanitize($title));
        $conn->bindValue(":desc",$this->sanitize($content));
        if($conn->execute()){
            return true;
        }
        return false;
    }

    public function edit(string $name, int $id, string $desc){
        $conn = $this->db->prepare("UPDATE category SET name = :name, description = :desc WHERE id = :id");
        $conn->bindValue(":id", $this->sanitize($id));
        $conn->bindValue(":desc", $this->sanitize($desc));
        $conn->bindValue(":name", $this->sanitize($name));
        $conn->execute();
    }

    public function archive(int $id,$state){
        $conn = $this->db->prepare("UPDATE category SET archive = :state WHERE id = :id");
        $conn->bindValue(":id", $this->sanitize($id));
        if($state === 1){
            $conn->bindValue(":state", 0);
        }
        else{
            $conn->bindValue(":state", 1);
        }
        $conn->execute();
    }
}