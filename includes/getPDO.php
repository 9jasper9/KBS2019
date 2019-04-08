<?php
function getPDO(){
    $db = 'mysql:host=jkapplications.nl;dbname=jk001_wwi;port=3306';
    $user='jk001_wwi';
    $pass='Mp7bmiekl';
    
    $pdo=NULL;
    
    // PC xampp server
    // negeer error, kan mac zijn.
    try{
    $pdo= new PDO($db,$user,$pass);
    } catch (PDOException $e){
        error_log('<H1>Normale mensen error: '.$e->getMessage().'</H1>');
    }
    

    // MAC xampp server
    if($pdo==NULL){
        try{
            $db = 'mysql:host=192.168.64.2;dbname=wideworldimporters;port=3306';
            $user='root';
            $pass='6kqvi5e6';
            $pdo= new PDO($db,$user,$pass);
        }catch(PDOException $e){
            error_log('<H1>Appel error: '.$e->getMessage().'</H1>');
            die();
        }
    }
    
    
    // Er is geen database verbinding. geef een error pagina
    if($pdo==NULL){
        die('<H1>Kon geen verbinding maken met de SQL-server</H1>');
    }
    
    return $pdo;
}
?>
