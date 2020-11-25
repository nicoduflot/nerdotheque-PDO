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

if( isset($_POST["addAuteur"]) && $_POST["addAuteur"] === "add" ){
    $messageSQL = addAuteur(utf8_decode(addslashes($_POST["nom"])), utf8_decode(addslashes($_POST["prenom"])), utf8_decode(addslashes($_POST["bio"])));
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Admin Médiathèque Ajout d'auteur</title>
        <?php include "./includes/admin-bootstrap.php"; ?>
    </head>
    <body class="container">
        <?php include "./includes/admin-menu.php"; ?>
        <section class="row">
            <article class="offset-3 col-lg-6">
            <form method="post">
                <div class="form-group row">
                    <label for="nom" class="col-lg-4">Nom :</label>
                    <input type="text" class="form-control col-lg-8" name="nom" id="nom" value="" 
                        placeholder="Renseignez le nom de l'auteur" required />
                </div>
                <div class="form-group row">
                    <label for="prenom" class="col-lg-4">Prénom :</label>
                    <input type="text" class="form-control col-lg-8" name="prenom" id="prenom" value="" 
                        placeholder="Renseignez le prénom de l'auteur" required />
                </div>
                <div class="form-group row">
                    <label for="bio" class="col-lg-4">Biographie :</label>
                    <textarea class="form-control" name="bio" id="bio" placeholder="Biographie de l'auteur"></textarea>
                </div>
                <button type="submit" name="addAuteur" value="add" class="btn btn-primary">Ajouter</button>
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