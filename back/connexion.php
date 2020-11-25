<?php
// ici on met le code php
session_start();
include "../functions/functions.php";
include "../functions/sql.php";
$messageConnexion = "";
//echo md5("admin");//21232f297a57a5a743894a0e4a801fc3
if( isset($_POST["submitConnexion"]) && $_POST["submitConnexion"] === "connexion" ){
    $email = strip_tags(addslashes($_POST["email"]) );
    $password = md5(strip_tags(addslashes($_POST["motdepasse"]) ) );
    //fonction de test de connexion en tant qu'admin

    if(getAuthentication($email, $password)){
        header("location: ./index.php");
    }else{
        $messageConnexion = "Problème d'identification, email ou mot de passe invalide";
        session_destroy();
        destroyCookie();
    }
}else{

}

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Admin Médiathèque</title>
        <?php include "./includes/admin-bootstrap.php"; ?>
    </head>
    <body class="container">
        <?php include "./includes/admin-menu.php"; ?>
        <section class="row">
            <article class="offset-3 col-lg-6">
                <h1>Connexion</h1>
                <form method="post">
                    <?php if($messageConnexion !== ""): ?>
                    <div class="row">
                        <div class="alert alert-danger" role="alert">
                        <?php echo $messageConnexion; ?>
                        </div>
                    </div>
                    <?php endif ?>
                    <div class="form-group-row">
                        <label for="email" class="col-lg-2">Email</label>
                        <input type="text" name="email" id="email" class="col-lg-6" />
                    </div>
                    <div class="form-group-row">
                        <label for="motdepasse" class="col-lg-2">Mot de passe</label>
                        <input type="password" name="motdepasse" id="motdepasse" class="col-lg-6" />
                    </div>
                    <div class="form-group-row">
                        <button name="submitConnexion" type="submit" value="connexion" class="offset-2 btn btn-primary">
                            Connexion
                        </button>
                    </div>
                </form>
            </article>
        </section>
    </body>
</html>
