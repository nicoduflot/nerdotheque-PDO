<?php
// ici on met le code php
session_start();
include "../../functions/functions.php";
include "../../functions/sql.php";

$messageSQL = "";

//if( isset($_POST["modMedia"]) && $_POST["modMedia"] === "mod" ){
//    echo "mechanical";
//    $messageSQL = modMedia(utf8_decode(addslashes($_POST["titre"])), utf8_decode(addslashes($_POST["resume"])), $_POST["idMedia"]);
//    return $messageSQL;
//}



if( isset($_GET["idMedia"]) ){
    $sql = "SELECT 
                `id` AS `idMedia`, `titre`, `resume`, `utilisateur_id` 
            FROM 
                `media` 
            WHERE 
                `id` = " . $_GET["idMedia"] . ";";
    //echo $sql;
    $result = selectBDD($sql);
    $nbRows = (!$result)? 0 : mysqli_num_rows($result);
    if($nbRows > 0){
        $row = mysqli_fetch_assoc($result);
        //var_dump($row);
        $jSonMedia = "
            {
                \"idMedia\": ".$row['idMedia'].",
                \"titre\": \"".utf8_encode($row['titre'])."\",
                \"resume\": \"".utf8_encode($row['resume'])."\",
                \"utilisateur_id\": ".$row['utilisateur_id']."
            }
        ";
        echo $jSonMedia;
        //return $row;
        return $jSonMedia;
    }else{
        //echo "pas de data";
        //header("location: ./index.php");
        //exit();
        return "No data";
    }
}else{
    $jSonMedia = file_get_contents("php://input");
    if(strlen($jSonMedia) > 0){
        $data = json_decode($jSonMedia, true);
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
