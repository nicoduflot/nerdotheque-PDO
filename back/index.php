<?php
// ici on met le code php
session_start();
include "../functions/functions.php";
include "../functions/sql.php";
if(!$_COOKIE["accesAdmin20200727"]){
    header("location: ../index.php");
    exit();
}
$bdd = openConn2();
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
            <article class="col-lg-6">
                <?php echo listMediaBack($bdd); ?>
            </article>
            <article class="col-lg-6">
                <?php echo listAuteurBack(); ?>
            </article>
        </section>
        <!-- Modal edit media -->
        <div class="modal fade" id="editMedia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Édition</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body m-1">
                            <div class="form-group row">
                                <label for="titre" class="col-lg-4">Titre :</label>
                                <input type="text" class="form-control col-lg-8" name="titre" id="titre" value=""
                                       placeholder="Renseignez le titre du média" required />
                            </div>
                            <div class="form-group row">
                                <label for="resume" class="col-lg-4">Résumé :</label>
                                <textarea class="form-control" name="resume" id="resume" placeholder="Résumé du média"></textarea>
                            </div>
                            <input type="hidden" name="idMedia" id="idMedia" value="" />
                            <input type="hidden" name="idUtilisateur" id="idUtilisateur" value="" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Annuler
                            </button>
                            <button type="submit" id="submitModMedia" data-dismiss="modal" class="btn btn-primary">
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal edit auteur -->
        <div class="modal fade" id="editAuteur" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Édition</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body m-1">
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
                            <input type="hidden" name="idAuteur" id="idAuteur" value="" />
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" id="submitModAuteur" data-dismiss="modal" class="btn btn-primary">
                            Sauvegarder les modifications
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
