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

//$sql = "SELECT `id` AS `idMedia`, `titre`, `resume` FROM `media` WHERE `id` = 4;";

if( isset($_POST["modAuteur"]) && $_POST["modAuteur"] === "mod" ){
    $messageSQL = modAuteur(utf8_decode(addslashes($_POST["nom"])), utf8_decode(addslashes($_POST["prenom"])), utf8_decode(addslashes($_POST["bio"])),  $_POST["idAuteur"]);
}

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
    }else{
        //echo "pas de data";
        header("location: ./index.php");
        exit();
    }
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Admin Médiathèque Edition de media</title>
        <?php include "./includes/admin-bootstrap.php"; ?>
    </head>
    <body class="container">
        <?php include "./includes/admin-menu.php"; ?>
        <section class="row">
            <article class="offset-3 col-lg-6">
            <form method="post">
            <div class="form-group row">
                    <label for="nom" class="col-lg-4">Nom :</label>
                    <input type="text" class="form-control col-lg-8" name="nom" id="nom" value="<?php echo utf8_encode($row["nom"]); ?>" 
                        placeholder="Renseignez le nom de l'auteur" required />
                </div>
                <div class="form-group row">
                    <label for="prenom" class="col-lg-4">Prénom :</label>
                    <input type="text" class="form-control col-lg-8" name="prenom" id="prenom" value="<?php echo utf8_encode($row["prenom"]); ?>" 
                        placeholder="Renseignez le prénom de l'auteur" required />
                </div>
                <div class="form-group row">
                    <label for="bio" class="col-lg-4">Biographie :</label>
                    <textarea class="form-control" name="bio" id="bio" placeholder="Biographie de l'auteur"><?php echo utf8_encode($row["bio"]); ?></textarea>
                </div>
                <input type="hidden" name="idAuteur" id="idAuteur" value="<?php echo $row["idAuteur"]; ?>" />
                <button type="submit" name="modAuteur" value="mod" class="btn btn-primary">Modifier</button>
            </form>
            <?php if($messageSQL !== "" ): ?>
                <div class="alert alert-info m-2">
                    <?php echo utf8_encode($messageSQL); ?>
                </div>
            <?php endif ?>
            </article>
        </section>
    </body>
</html>