<?php

use Controller\Traits\GlobalManagerTrait;

class TokenManager
{
    use GlobalManagerTrait;

    public function createToken($mail){
        $conn = $this->db->prepare("SELECT id FROM token WHERE mail = :mail");
        $conn->bindValue(":mail",$this->sanitize($mail));
        if($conn->execute()){
            if($conn->fetch()){
                return "Un mail vous a déjà été envoyé";
            }
            else{
                $conn = $this->db->prepare("INSERT INTO token (mail, token, date) VALUES (:mail, :token, :date)");
                $conn->bindValue(":mail", $this->sanitize($mail));
                $conn->bindValue(":token", random_bytes(10));
                if($conn->execute()){
                    return true;
                }
                else{
                    return "erreur lors de l'envoi du lien d'inscription";
                }
            }
        }
        else{
            return "erreur lors de l'envoi du lien";
        }
    }
}