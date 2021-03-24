<?php
// ici on met le code php
session_start();
include "../../functions/sql.php";
include "../../functions/functions.php";

$messageSQL = "";

$content = trim(file_get_contents("php://input"));

$data = json_decode($content, true);
$data['success'] = true;

if(isset($data["modMedia"]) && $data["modMedia"] === "mod"){
    modMedia(utf8_decode(addslashes($data["titre"])), utf8_decode(addslashes($data["resume"])), $data["idMedia"], $bdd);
}

if( isset($_GET["idMedia"]) ){
    $sql = "SELECT 
                `id` AS `idMedia`, `titre`, `resume`, `utilisateur_id` 
            FROM 
                `media` 
            WHERE 
                `id` = :idMedia;";
    $response = $bdd->prepare($sql);
    $response->execute(array("idMedia"=>$_GET["idMedia"]));
    $nbRows = $nbRows = $response->rowCount();
    if($nbRows > 0){
        $donnees = $response->fetch();
        $jSonMedia = "
            {
                \"idMedia\": \"".$donnees['idMedia']."\",
                \"titre\": \"".$donnees['titre']."\",
                \"resume\": \"".$donnees['resume']."\",
                \"utilisateur_id\": ".$donnees['utilisateur_id']."
            }
        ";
        echo $jSonMedia;
        return $jSonMedia;
    }else{
        return "No data";
    }
}else{
    /*
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
    }*/
}
?>
