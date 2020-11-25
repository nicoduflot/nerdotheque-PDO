<?php
// ici on met le code php
session_start();
include "./functions/functions.php";
include "./functions/sql.php";

$listAuteurAssoc = "";

if( isset( $_GET["idMedia"] ) && $_GET["idMedia"] !== "" ){
    //$nbRows = (!$result)? 0 : mysqli_num_rows($result);
    //return ($nbRows > 0)?mysqli_fetch_assoc($result) : ["error"=>"Pas d'enregistrement pour l'id : \"".$idMedia."\""] ;
    $idMedia = $_GET["idMedia"];
    //$tabMedia = afficheMedia($idMedia);
    $result = afficheMedia($idMedia);
    $i = 0;
    $cptMedia = 0;
    $nbRows = (!$result)? 0 : mysqli_num_rows($result);
    if($nbRows === 0){
        $tabMedia = ["error"=>"Pas d'enregistrement pour l'id : \"".$idMedia."\""];
    }else{
        $listAuteurAssoc = $listAuteurAssoc . "<h2>Auteur(s) enregistré(s)</h2>";
        $listAuteurAssoc = $listAuteurAssoc . "<ul>";
        while($i < $nbRows){
            $tabMedia = mysqli_fetch_assoc($result);
            //var_dump($tabAuteur);
            if($tabMedia["prenomNom"] !== NULL){
                $listAuteurAssoc = $listAuteurAssoc . "<li>";
                $listAuteurAssoc = $listAuteurAssoc . "<a href=\"./auteur.php?idAuteur=" . $tabMedia["idAuteur"] . "\">";
                $listAuteurAssoc = $listAuteurAssoc . utf8_encode($tabMedia["prenomNom"]);
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
                    <h1><?php echo utf8_encode($tabMedia["titre"]); ?></h1>
                    <?php echo $listAuteurAssoc; ?>
                    <p>
                        Enregistré par <?php echo searchUser($tabMedia["utilisateur_id"]); ?>
                    </p>
                    <h2>Résumé :</h2>
                    <p>
                    <?php echo utf8_encode($tabMedia["resume"]); ?>
                    </p>
                <?php endif ?>
                <?php /*
                echo "<pre>";
                print_r($tabMedia);
                echo "</pre>";*/
                ?>
            </article>
        </section>
    </body>
</html>