<?php

use Controller\Traits\GlobalManagerTrait;

class UserManager
{
    use GlobalManagerTrait;

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
                        ->setRole((new RoleManager)->getSingleEntity($result["role_fk"]));
                }
            }
            return false;
        }
        return false;
    }
}