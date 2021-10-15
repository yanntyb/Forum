<?php

namespace Yanntyb\App\Model\Classes\Manager;

use Yanntyb\App\Model\Classes\Entity\User;

use Yanntyb\App\Model\Traits\GlobalManagerTrait;

class UserManager
{
    use GlobalManagerTrait;

    /**
     * Check if password match with name in database
     * @param $name
     * @param $pass
     * @return User|bool
     */
    public function checkLog($name, $pass){
        $conn = $this->db->prepare("SELECT * FROM user WHERE name = :name");
        $conn->bindValue(":name", $name);
        if($conn->execute()){
            $result = $conn->fetch();
            if($result){
                if($result["pass"] === $pass){
                    return (new User)
                        ->setName($result["name"])
                        ->setId($result["id"])
                        ->setRole((new RoleManager)->getSingleEntity($result["role_fk"]))
                        ->setImg($result["img"])
                        ->setPass($result["pass"]);
                }
                return false;
            }
            return false;
        }
        return false;
    }

    /**
     * Insert a new User in database
     * @param $mail
     * @param string $name
     * @param string $pass
     * @return bool
     */
    public function insertUser($mail): bool
    {
        $conn = $this->db->prepare("INSERT INTO user (name, pass) VALUES (:name, :pass)");
        $conn->bindValue(":name", $this->sanitize($mail));
        $conn->bindValue(":pass","");
        if($conn->execute()){
            return true;
        }
        return false;
    }

    public function changePass(string $newPass, int $id){
        $conn = $this->db->prepare("UPDATE user SET pass = :pass WHERE id = :id");
        $conn->bindValue(":pass", $this->sanitize($newPass));
        $conn->bindValue(":id", $id);
        $conn->execute();
    }

    public function changeName(string $newName, int $id){
        $conn = $this->db->prepare("UPDATE user SET name = :name WHERE id = :id");
        $conn->bindValue(":name", $this->sanitize($newName));
        $conn->bindValue(":id", $id);
        $conn->execute();
    }

    public function delete($id){
        $conn = $this->db->prepare("DELETE FROM user WHERE id = :id");
        $conn->bindValue(":id", $id);
        $conn->execute();
    }
}