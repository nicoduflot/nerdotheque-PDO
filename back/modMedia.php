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
if( isset($_POST["modMedia"]) && $_POST["modMedia"] === "mod" ){
    $messageSQL = modMedia(utf8_decode(addslashes($_POST["titre"])), utf8_decode(addslashes($_POST["resume"])), $_POST["idMedia"]); 
    echo $messageSQL;
}

if( isset($_GET["idMedia"]) ){
    $sql = "SELECT 
                `id` AS `idMedia`, `titre`, `resume`, `utilisateur_id` 
            FROM 
                `media` 
            WHERE 
                `id` = " . $_GET["idMedia"] . ";";
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
                    <label for="titre" class="col-lg-4">Titre :</label>
                    <input type="text" class="form-control col-lg-8" name="titre" id="titre" value="<?php echo utf8_encode($row["titre"]); ?>" 
                        placeholder="Renseignez le titre du média" required />
                </div>
                <div class="form-group row">
                    <label for="resume" class="col-lg-4">Résumé :</label>
                    <textarea class="form-control" name="resume" id="resume" placeholder="Résumé du média"><?php echo utf8_encode($row["resume"]); ?></textarea>
                </div>
                <input type="hidden" name="idMedia" id="idMedia" value="<?php echo $row["idMedia"]; ?>" />
                <input type="hidden" name="idUtilisateur" id="idUtilisateur" value="<?php echo $row["utilisateur_id"]; ?>" />
                <button type="submit" name="modMedia" value="mod" class="btn btn-primary">Modifier</button>
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
