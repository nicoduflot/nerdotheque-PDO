<?php
// ici on met le code php
session_start();
include "./functions/functions.php";
include "./functions/frontFunctions.php";
include "./functions/sql.php";

$listMediaAssoc = "";

if( isset( $_GET["idAuteur"] ) && $_GET["idAuteur"] !== "" ){
    $idAuteur = $_GET["idAuteur"];
    $response = afficheAuteur($idAuteur, $bdd);
    $i = 0;
    $cptMedia = 0;
    $nbRows = $response->rowCount();
    if($nbRows === 0){
        $tabAuteur = ["error"=>"Pas d'enregistrement pour l'id : \"".$idAuteur."\""];
    }else{
        $listMediaAssoc = $listMediaAssoc . "<h2>Livre(s) enregistré(s)</h2>";
        $listMediaAssoc = $listMediaAssoc . "<ul>";
        while($i < $nbRows){
            $tabAuteur = $response->fetch();
            //var_dump($tabAuteur);
            if($tabAuteur["titre"] !== NULL){
                $listMediaAssoc = $listMediaAssoc . "<li>";
                $listMediaAssoc = $listMediaAssoc . "<a href=\"./media.php?idMedia=" . $tabAuteur["idMedia"] . "\">";
                $listMediaAssoc = $listMediaAssoc . $tabAuteur["titre"];
                $listMediaAssoc = $listMediaAssoc . "</a>";
                $listMediaAssoc = $listMediaAssoc . "</li>";
                $cptMedia++;
            }
            $i++;
        }
        $listMediaAssoc = $listMediaAssoc . "</ul>";
        if($cptMedia === 0){
            $listMediaAssoc = "";
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
        <?php if(array_key_exists("error", $tabAuteur)): ?>
            <title>Médiathèque - <?php echo $tabAuteur["error"]; ?></title>
        <?php else: ?>
            <title>Médiathèque - <?php echo $tabAuteur["prenomNom"]; ?></title>
        <?php endif ?>
        <?php include "./includes/bootstrap.php"; ?>
    </head>
    <body class="container">
        <?php include "./includes/menu.php"; ?>
        <section class="row">
            <article class="col-lg-12">
                <?php if(array_key_exists("error", $tabAuteur)): ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo $tabAuteur["error"]; ?>
                    </div>
                <?php else: ?>
                    <h1><?php echo $tabAuteur["prenomNom"]; ?></h1>
                    <?php echo $listMediaAssoc; ?>
                    <h2>Bio :</h2>
                    <p>
                    <?php echo $tabAuteur["bio"]; ?>
                    </p>
                <?php endif ?>
            </article>
        </section>
    </body>
</html>
