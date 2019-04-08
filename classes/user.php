<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Bas Scholma
 */
class user
{

    public function fetch($id)
    {
        try {
            global $connection;
            $sql = "SELECT * FROM webshopklant WHERE AccountID = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindparam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function validate($email, $hash)
    {
        try {
            global $connection;
            $sql = "SELECT * FROM webshopklant WHERE email = :email AND wachtwoord = :wachtwoord";
            $stmt = $connection->prepare($sql);
            $stmt->bindparam(':email', $email, PDO::PARAM_STR);
            $stmt->bindparam(':wachtwoord', $hash, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    // probeer
    function login($email, $password)
    {
        $hash = hash('sha256', $email . $password);
        $user = $this->validate($email, $hash);
        if (isset($user['AccountID'])) {
            $_SESSION["userID"] = (int)$user['AccountID'];
            header('Location: index.php');
        } else {
            return "U heeft een verkeerd e-mailadres en/of wachtwoord ingevuld.";
        }
        //check of de gebruiker bestaat.
    }

    // creer een account.
    // als het een tijdelijk account is, laat $password dan NULL.
    // deze functie logt de gebruiker meteen in.
    function createAccount($email, $password, $firstname, $lastname, $phone, $gebdatum, $postcode, $huisnummer, $woonplaats, $straatnaam){
        global $connection;
        if($password!=null){
            $hash = hash('sha256', $email . $password);
        }else{
            $hash=null;
        }
        
        
        $sql = "insert into webshopklant(email, wachtwoord, voornaam, achternaam, telefoon, geboortedatum, postcode, huisnummer, woonplaats, straatnaam)"
                . " VALUES (:email, :pass, :voornaam, :achternaam, :telefoon, :geboortedatum, :postcode, :huisnummer, :woonplaats, :straatnaam)";
        
        $stmt = $connection->prepare($sql);
        $stmt->bindparam(':email', $email, PDO::PARAM_STR);
        $stmt->bindparam(':pass', $hash, PDO::PARAM_STR);
        $stmt->bindparam(':voornaam', $firstname, PDO::PARAM_STR);
        $stmt->bindparam(':achternaam', $lastname, PDO::PARAM_STR);
        $stmt->bindparam(':telefoon', $phone, PDO::PARAM_STR);
        $stmt->bindparam(':geboortedatum', $gebdatum, PDO::PARAM_STR);
        
        $stmt->bindparam(':postcode', $postcode, PDO::PARAM_STR);
        $stmt->bindparam(':woonplaats', $woonplaats, PDO::PARAM_STR);
        $stmt->bindparam(':straatnaam', $straatnaam, PDO::PARAM_STR);
        $stmt->bindparam(':huisnummer', $huisnummer, PDO::PARAM_INT);

        $stmt->execute();
        
        
        // verkrijg het account id dat we net hebben aangemaakt.
        $sql2="SELECT max(AccountID) id FROM webshopklant;";
        $stmt2 = $connection->prepare($sql2);
        $stmt2->execute();
        // stel de userID in.
        $_SESSION["userID"]=$stmt2->fetch()[0];
        return "Bedankt voor het registreren, u kunt nu verder gaan.";
        
    }



// logt de gebruiker uit.
function logout()
{
    unset($_SESSION["userID"]);
    unset($_SESSION["winkelmandje"]);
}

// geeft TRUE terug als de gebruiker is ingelogd.
function isLoggedIn()
{
    return isset($_SESSION["userID"]) and $_SESSION["userID"] != null;
}

// geeft de user id terug van de ingelogde gebruiker.
// indien er geen gebruiker is ingelogd, geeft deze functie NULL terug
function getUserID()
{
    if (isset($_SESSION["userID"])) {
        return (int)$_SESSION["userID"];
    }
    return null;
}


}