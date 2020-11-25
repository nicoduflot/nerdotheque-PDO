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

if( isset($_POST["addMedia"]) && $_POST["addMedia"] === "add" ){
    $messageSQL = addMedia(utf8_decode(addslashes($_POST["titre"])), utf8_decode(addslashes($_POST["resume"])), $_POST["idUtilisateur"]);
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Admin Médiathèque Ajout de media</title>
        <?php include "./includes/admin-bootstrap.php"; ?>
    </head>
    <body class="container">
        <?php include "./includes/admin-menu.php"; ?>
        <section class="row">
            <article class="offset-3 col-lg-6">
            <form method="post">
                <div class="form-group row">
                    <label for="titre" class="col-lg-4">Titre :</label>
                    <input type="text" class="form-control col-lg-8" name="titre" id="titre" value="" 
                        placeholder="Renseignez le titre du média" required />
                </div>
                <div class="form-group row">
                    <label for="resume" class="col-lg-4">Résumé :</label>
                    <textarea class="form-control" name="resume" id="resume" placeholder="Résumé du média"></textarea>
                </div>
                <input type="hidden" name="idUtilisateur" id="idUtilisateur" value="<?php echo $_SESSION["utilisateurId20200727"]; ?>" />
                <button type="submit" name="addMedia" value="add" class="btn btn-primary">Ajouter</button>
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