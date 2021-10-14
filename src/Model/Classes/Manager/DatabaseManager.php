<?php

namespace Yanntyb\App\Model\Classes\Manager;

use Yanntyb\App\Model\Classes\DB;
use Yanntyb\App\Model\Traits\GlobalManagerTrait;

class DatabaseManager
{
    use GlobalManagerTrait;

    public function __construct(){
        $this->db = DB::getInstance();
    }

    public function createTable(string $name): bool
    {
        $conn = $this->db->prepare("CREATE TABLE IF NOT EXISTS " . $this->sanitize($name) . " (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT)");
//        $conn->bindValue(":name", $this->sanitize(strtolower($name)));
        if($conn->execute()){
            return true;
        }
        return false;
    }

    public function createColumn($class, string $title, bool $isBuiltin, $type): string
    {
        if($isBuiltin){
            if($type === "int"){
                $type = "INTEGER";

            }
            else if($type === "string"){
                $type = "TEXT";
            }
        }
        else{
            $type = "INTEGER NOT NULL";
            $title = $title . "_fk";
        }
        dump($type);
        $conn = $this->db->prepare("ALTER TABLE {$class} ADD  {$title}  {$type}");
        $conn->execute();
        return "{$class} {$title} {$type}";
    }

    public function createConstrain($class, $title){

    }
}