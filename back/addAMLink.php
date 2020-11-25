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

if( isset($_POST["addAMLink"]) && $_POST["addAMLink"] === "add" ){
    $messageSQL = addAMLink($_POST["idAuteur"], $_POST["idMedia"]);
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Admin Médiathèque Ajout lien auteur - média</title>
        <?php include "./includes/admin-bootstrap.php"; ?>
    </head>
    <body class="container">
        <?php include "./includes/admin-menu.php"; ?>
        <section class="row">
            <article class="offset-3 col-lg-6">
            <form method="post">
                <div class="form-group row">
                    <?php echo createAuthorSelect(); ?>
                </div>
                <div class="form-group row">
                    <?php echo createMediaSelect(); ?>
                </div>
                <button type="submit" name="addAMLink" value="add" class="btn btn-primary">Ajouter</button>
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