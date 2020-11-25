<?php
// ici on met le code php
session_start();
include "../functions/functions.php";
include "../functions/sql.php";
if(!$_SESSION["accesAdmin20200727"]){
    header("location: ../index.php");
    exit();
}
$messageSQL = "";
$entite = "";
$idEntite = "";

if(isset($_GET["entite"]) && isset($_GET["id"]) &&  $_GET["entite"] != "" && $_GET["id"] != ""){
    $entite = $_GET["entite"];
    $idEntite = $_GET["id"];
    $messageSQL = utf8_decode("Êtes vous sûr de vouloir supprimer l'entrée ". $idEntite . " de la table " . $entite);
}

if( isset($_POST["supEntite"]) && $_POST["supEntite"] === "sup" ){
    $messageSQL = deleteEntite($_POST["entite"], $_POST["id"]);
    //$messageSQL = "";
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Admin Médiathèque suppression d'une entité </title>
        <?php include "./includes/admin-bootstrap.php"; ?>
    </head>
    <body class="container">
        <?php include "./includes/admin-menu.php"; ?>
        <section class="row">
            <article class="offset-3 col-lg-6">
            <?php if($messageSQL !== "" ): ?>
                
                <form method="post">
                    <div class="alert alert-info m-2">
                        <?php echo utf8_encode($messageSQL); ?>
                    </div>
                    <input type="hidden" name="entite" id="entite" value="<?php echo $entite; ?>" />
                    <input type="hidden" name="id" id="id" value="<?php echo $idEntite; ?>" />
                    <button type="submit" name="supEntite" value="sup" class="btn btn-success">Supprimer</button>
                    <a href="./index.php">Annuler la suppression</a>
                </form>
            <?php endif ?>
            
            </article>
        </section>
    </body>
</html>