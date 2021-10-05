<?php

namespace Controller\Traits;

use App\Classes\DB;
use PDO;
use PDOException;

trait GlobalManagerTrait
{

    private ?PDO $db;
    private string $name;
    private array $fk;

    /**
     * ArticleManager constructor.
     */
    public function __construct(){
        $this->db = DB::getInstance();
        $this->name = $this->getClassName();
        $this->fk = [];
    }

    public function sanitize(string $data): string
    {
        return trim(stripslashes(htmlspecialchars(addslashes($data))));
    }

    public function getSingleEntity(int $id){
        $conn = $this->db->prepare("SELECT * FROM " . strtolower($this->name) . " WHERE id = :id");
        $conn->bindValue(":id", $id);
        if($conn->execute()){
            $results = $conn->fetch();
            //Créée l'entité qui porte le nom $name
            $obj = new $this->name;
            //Parcoure toute les valeurs fetch
            foreach($results as $col => $value){
                //setId(), setName(), ...
                $methode = "set" . ucfirst($col);
                //Check si la methode existe
                if(method_exists($obj,$methode)){
                    //Si elle existe alors on définie
                    $obj->$methode($value);
                }
            }
            return $obj;
        }
    }

    public function getAllEntity(): array
    {
        $conn = $this->db->prepare("SELECT * FROM " . strtolower($this->name));
        $return = [];
        if($conn->execute()){
            $results = $conn->fetchAll();
            foreach($results as $result){
                $obj = $this->createObj($this->name,true);
                foreach($result as $col => $value){
                    $obj2 = $this->createObj($col,false,$value);
                    $methode = "set" . ucfirst(explode("_",$col)[0]);
                    if(method_exists($obj,$methode)){
                        if(is_null($obj2)){
                            $obj = $obj->$methode($value);
                        }
                        else{
                            $obj = $obj->$methode($obj2);
                        }
                    }

                }
                $return[] = $obj;
            }
        }
        return $return;
    }

    public function getClassName(){
        if(strpos(get_class($this),"\\") !== false){
            $fullName = str_split(explode("\\",get_class($this))[2]);
        }
        else{
            $fullName = str_split(get_class($this));
        }

        $countUpper = 0;
        foreach($fullName as $index => $letter){
            if(ctype_upper($letter)){
                $countUpper++;
            }
            if($countUpper === 2){
                return substr(implode($fullName),0,$index);
            }
        }
    }

    public function checkIfTableExist(string $name): bool
    {
        //Si $name n'a pas encore été check alors on test si la table existe
        if(!in_array($name,$this->fk)){
            try{
                $conn = $this->db->prepare("SELECT 1 FROM " . explode("_",$name)[0]);
                if($conn->execute()){;
                    $this->fk[] = $name;
                    return true;
                }
                else{
                    return false;
                }
            }
            catch (PDOException $e){
                return false;
            }
        }
        else{
            return true;
        }
    }

    //Si $first === true c'est que c'est la premiere iteration , le manager correspond donc et on a pas besoin den créé un nouveau
    public function createObj(string $name, bool $first, $id = 0){
        if($first){
            return new $name;
        }
        else{
            if($this->checkIfTableExist($name)){
                $subObjName = ucfirst(explode("_",$name)[0]);
                $managerName = $subObjName . "Manager";
                $manager = new $managerName;
                return $manager->getSingleEntity($id);
            }
        }
    }
}