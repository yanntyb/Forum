<?php

use Controller\Traits\GlobalManagerTrait;

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
                echo $token;
                $conn = $this->db->prepare("INSERT INTO token (mail, token) VALUES (:mail, :token)");
                $conn->bindValue(":mail", $this->sanitize($mail));
                $conn->bindValue(":token", $token);
                if($conn->execute()){

                    mail($mail,"Création de compte pour le projet forum","<a href='localhost:'" . $_SERVER["SERVER_PORT"] . "/index.php?page=checkToken&token=" . $token ."'>Lien d'inscription</a>");
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