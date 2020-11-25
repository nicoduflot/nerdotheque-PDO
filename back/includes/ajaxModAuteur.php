<?php
// ici on met le code php
session_start();
include "../../functions/functions.php";
include "../../functions/sql.php";

$messageSQL = "";

if( isset($_GET["idAuteur"]) ){
    $sql = "SELECT 
                `id` AS `idAuteur`, `nom`, `prenom`, `bio` 
            FROM 
                `auteur` 
            WHERE 
                `id` = " . $_GET["idAuteur"] . ";";
    //echo $sql;
    $result = selectBDD($sql);
    $nbRows = (!$result)? 0 : mysqli_num_rows($result);
    if($nbRows > 0){
        $row = mysqli_fetch_assoc($result);
        //var_dump($row);
        $jSonAuteur = "
            {
                \"idAuteur\": ".$row['idAuteur'].",
                \"nom\": \"".utf8_encode($row['nom'])."\",
                \"prenom\": \"".utf8_encode($row['prenom'])."\",
                \"bio\": \"".utf8_encode($row['bio'])."\"
            }
        ";
        echo $jSonAuteur;
        //return $row;
        return $jSonAuteur;
    }else{
        //echo "pas de data";
        //header("location: ./index.php");
        //exit();
        return "No data";
    }
}else{
    $jsonData = file_get_contents("php://input");
    if(strlen($jsonData) > 0){
        $data = json_decode($jsonData, true);
        if (!(json_last_error() == JSON_ERROR_NONE and is_array($data))){
            die('Données JSON invalides.');
        }
        $messageSQL = modAuteur(utf8_decode(addslashes($data["nom"])), utf8_decode(addslashes($data["prenom"])), utf8_decode(addslashes($data["bio"])),  $data["idAuteur"]);
        return $messageSQL;
    } else{
        die('Aucune données JSON.');
    }
}
?>
