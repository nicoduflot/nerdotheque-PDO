<?php
// ici on met le code php
session_start();
include "./functions/functions.php";
include "./functions/frontFunctions.php";
include "./functions/sql.php";

$listAuteurAssoc = "";

if( isset( $_GET["idMedia"] ) && $_GET["idMedia"] !== "" ){
    $idMedia = $_GET["idMedia"];
    $response = afficheMedia($idMedia, $bdd);
    $i = 0;
    $cptMedia = 0;
    $nbRows = $response->rowCount();
    //var_dump($response);
    if($nbRows === 0){
        $tabMedia = ["error"=>"Pas d'enregistrement pour l'id : \"".$idMedia."\""];
    }else{
        $listAuteurAssoc = $listAuteurAssoc . "<h2>Auteur(s) enregistré(s)</h2>";
        $listAuteurAssoc = $listAuteurAssoc . "<ul>";
        while($i < $nbRows){
            $tabMedia = $response->fetch();
            if($tabMedia["prenomNom"] !== NULL){
                $listAuteurAssoc = $listAuteurAssoc . "<li>";
                $listAuteurAssoc = $listAuteurAssoc . "<a href=\"./auteur.php?idAuteur=" . $tabMedia["idAuteur"] . "\">";
                $listAuteurAssoc = $listAuteurAssoc . $tabMedia["prenomNom"];
                $listAuteurAssoc = $listAuteurAssoc . "</a>";
                $listAuteurAssoc = $listAuteurAssoc . "</li>";
                $cptMedia++;
            }
            $i++;
        }
        $listAuteurAssoc = $listAuteurAssoc . "</ul>";
        if($cptMedia === 0){
            $listAuteurAssoc = "";
        }
    }
    $response->closeCursor();
}else{
    header("location: ./index.php");
    exit();
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <?php if(array_key_exists("error", $tabMedia)): ?>
            <title>Médiathèque - <?php echo $tabMedia["error"]; ?></title>
        <?php else: ?>
            <title>Médiathèque - <?php echo utf8_encode($tabMedia["titre"]); ?></title>
        <?php endif ?>
        <?php include "./includes/bootstrap.php"; ?>
    </head>
    <body class="container">
        <?php include "./includes/menu.php"; ?>
        <section class="row">
            <article class="col-lg-12">
                <?php if(array_key_exists("error", $tabMedia)): ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo $tabMedia["error"]; ?>
                    </div>
                <?php else: ?>
                    <h1><?php echo $tabMedia["titre"]; ?></h1>
                    <?php echo $listAuteurAssoc; ?>
                    <p>
                        Enregistré par <?php echo searchUser($tabMedia["utilisateur_id"]); ?>
                    </p>
                    <h2>Résumé :</h2>
                    <p>
                    <?php echo $tabMedia["resume"]; ?>
                    </p>
                <?php endif ?>
            </article>
        </section>
    </body>
</html>
