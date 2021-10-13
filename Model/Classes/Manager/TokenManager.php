<?php

use Yanntyb\App\Model\Traits\GlobalManagerTrait;

class TokenManager
{
    use GlobalManagerTrait;

    /**
     * Send a token to a mail
     * @param $mail
     * @return bool|string
     * @throws Exception
     */
    public function createToken($mail){
        $conn = $this->db->prepare("SELECT id FROM token WHERE mail = :mail");
        $conn->bindValue(":mail",$this->sanitize($mail));
        if($conn->execute()){
            if($conn->fetch()){
                return "Un mail vous a déjà été envoyé";
            }
            else{
                $token = utf8_encode(bin2hex(random_bytes(50)));
                $conn = $this->db->prepare("INSERT INTO token (mail, token) VALUES (:mail, :token)");
                $conn->bindValue(":mail", $this->sanitize($mail));
                $conn->bindValue(":token", $token);
                if($conn->execute()){
                    echo $token;
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

    /**
     * Remove token from database based on his id
     * @param $tokenId
     * @return bool
     */
    public function removeToken($tokenId): bool
    {
        $check = $this->getSingleEntity($tokenId);
        if($check){
            $conn = $this->db->prepare("DELETE FROM token WHERE id = :id");
            $conn->bindValue(":id",$this->sanitize($tokenId));
            if($conn->execute()){
                return true;
            }
            return false;
        }
        return false;

    }
}