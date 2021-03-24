<?php
// ici on met le code php
session_start();
include "../../functions/functions.php";
include "../../functions/sql.php";

$messageSQL = "";

$content = trim(file_get_contents("php://input"));

$data = json_decode($content, true);
$data['success'] = true;

if(isset($data["modAuteur"]) && $data["modAuteur"] === "mod"){
    modAuteur(utf8_decode(addslashes($data["nom"])), utf8_decode(addslashes($data["prenom"])), utf8_decode(addslashes($data["bio"])),  $data["idAuteur"], $bdd);
}

if( isset($_GET["idAuteur"]) ){
    $sql = "SELECT 
                `id` AS `idAuteur`, `nom`, `prenom`, `bio` 
            FROM 
                `auteur` 
            WHERE 
                `id` = :idAuteur;";
    //echo $sql;
    $response = $bdd->prepare($sql);
    $response->execute(array("idAuteur"=>$_GET["idAuteur"]));
    $nbRows = $nbRows = $response->rowCount();
    if($nbRows > 0){
        $donnees = $response->fetch();
        $jSonAuteur = "
            {
                \"idAuteur\": \"".$donnees['idAuteur']."\",
                \"nom\": \"".$donnees['nom']."\",
                \"prenom\": \"".$donnees['prenom']."\",
                \"bio\": \"".$donnees['bio']."\"
            }
        ";
        echo $jSonAuteur;
        return $jSonAuteur;
    }else{
        return "No data";
    }
}
