<?php
// ici on met le code php
session_start();
include "./functions/functions.php";
include "./functions/sql.php";

$listMediaAssoc = "";

if( isset( $_GET["idAuteur"] ) && $_GET["idAuteur"] !== "" ){
    $idAuteur = $_GET["idAuteur"];
    $result = afficheAuteur($idAuteur);
    $i = 0;
    $cptMedia = 0;
    $nbRows = (!$result)? 0 : mysqli_num_rows($result);
    if($nbRows === 0){
        $tabAuteur = ["error"=>"Pas d'enregistrement pour l'id : \"".$idAuteur."\""];
    }else{
        $listMediaAssoc = $listMediaAssoc . "<h2>Livre(s) enregistré(s)</h2>";
        $listMediaAssoc = $listMediaAssoc . "<ul>";
        while($i < $nbRows){
            $tabAuteur = mysqli_fetch_assoc($result);
            //var_dump($tabAuteur);
            if($tabAuteur["titre"] !== NULL){
                $listMediaAssoc = $listMediaAssoc . "<li>";
                $listMediaAssoc = $listMediaAssoc . "<a href=\"./media.php?idMedia=" . $tabAuteur["idMedia"] . "\">";
                $listMediaAssoc = $listMediaAssoc . utf8_encode($tabAuteur["titre"]);
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
            <title>Médiathèque - <?php echo utf8_encode($tabAuteur["prenomNom"]); ?></title>
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
                    <h1><?php echo utf8_encode($tabAuteur["prenomNom"]); ?></h1>
                    <?php echo $listMediaAssoc; ?>
                    <h2>Bio :</h2>
                    <p>
                    <?php echo utf8_encode($tabAuteur["bio"]); ?>
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