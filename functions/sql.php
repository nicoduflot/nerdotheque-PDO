<?php
/**
 * 
 * Fonction pour les manipulations en base de données
 * 
 */

 //connection à une base de donnée

 function openConn($dbHost = "localhost", $dbUser = "20200727", $dbPass = "admin", $db = "20200727"){
    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $db) or die("message : " . $conn->error);
    return $conn;
 }

 function openConn2(){
     try {
         $conn = new PDO("mysql:host=localhost;dbname=20200727;charset=utf8",
             "root",
             "", array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
         //$bdd->
         return $conn;
     }catch(Exception $e){
         die("Erreur connexion : " . $e->getMessage());
     }
 }

 function closeConn($conn){
     mysqli_close($conn);
 }

 function selectBDD($sql){
    //$listeMedia = "Liste Média";
    $link = openConn();
    $result = mysqli_query($link, $sql);
    closeConn($link);
    return $result;
 }

 function changeBDD($sql, $table){
    $link = openConn();
    if( mysqli_query($link, $sql) ){ //si la requête a fonctionné :
        $messageSQL = "Modification la table `".$table."` : <br />" . 
        "<code>" . $sql . "</code>";
    }else{ //si la requête a échouée
        $messageSQL = "ERREUR : <br />" . 
        "<code>" . $sql . "</code>" . 
        mysqli_error($link);
    }
    //une fois qu'on a fini de faire ce qu'on voulait sur la connexion, il faut la fermer
    closeConn($link);
    return $messageSQL;
 }

 // $link = openConn();
 // $result = mysql_query($link, $sql);

?>
