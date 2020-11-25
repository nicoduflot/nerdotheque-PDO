<?php
// ici on met le code php
session_start();
include "./functions/functions.php";
include "./functions/sql.php";

//echo md5("admin");//21232f297a57a5a743894a0e4a801fc3

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Médiathèque</title>
        <?php include "./includes/bootstrap.php"; ?>
    </head>
    <body class="container">
        <?php include "./includes/menu.php"; ?>
        <section class="row">
            <article class="col-lg-6">
                <h1>Média enregistré(s)</h1>
                <?php echo listMedia(); ?>
            </article>
            <article class="col-lg-6">
                <h1>Auteur(s) enregistré(s)</h1>
                <?php echo listAuteur(); ?>
            </article>
        </section>
    </body>
</html>