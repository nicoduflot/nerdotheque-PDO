<?php
//fonctions pour les utilisateurs
function searchUser($idUtilisateur = ""){
    $pseudoUtilisateur = "anonyme";
    if($idUtilisateur !== ""){
        $sql = "SELECT 
                    `pseudo` 
                FROM 
                    `utilisateur` 
                WHERE `id` = " . $idUtilisateur . ";";
        $result = selectBDD($sql);
        $nbRows = (!$result)? 0 : mysqli_num_rows($result);
        $pseudoUtilisateur = ($nbRows > 0) ? mysqli_fetch_assoc($result)["pseudo"] : " un utilisateur";
    }
    return ($idUtilisateur === "")? $pseudoUtilisateur : $pseudoUtilisateur;
}

//fonctions sur les media backoffice
function listMediaBack($bdd){
    $sql = "SELECT `id` AS `idMedia`, `titre` AS `titreMedia` FROM `media` ORDER BY `titre`";
    $response = $bdd->prepare($sql);
    $response->execute();
    $nbRows = $response->rowCount();
    $tabResult = "";
    $tabResult .= "<table class=\"table\">";
    $tabResult .= "<thead class=\"thead-dark\"><tr>";
    $tabResult .= "<th>Titre</th><th colspan=\"2\">Actions</th>";
    $tabResult .= "</tr></thead>";
    $tabResult .= "<tbody>";
    while ($donnees = $response->fetch()) {
        $tabResult .= "<tr>";
        $tabResult .= "<td>" . $donnees["titreMedia"] . "</td>";
        $tabResult .= "<td>";
        $tabResult .= "<button class='btn btn-sm btn-outline-primary editMediaButton' data-id='" .
            $donnees["idMedia"] . "' data-toggle=\"modal\" data-target=\"#editMedia\">";
        $tabResult .= "Editer</button> ";
        $tabResult .= "</td>";
        $tabResult .= "<td>";
        $tabResult .= "<a href=\"supEntite.php?entite=media&id=" . $donnees["idMedia"] . "\">Supprimer</a>";
        $tabResult .= "</td>";
        $tabResult .= "</tr>";
    }
    $tabResult .="</tbody>";
    $tabResult .= "</table>";
    $listeMedia = $tabResult;
    $response->closeCursor();
    return $listeMedia;
}

function addMedia($titre, $resume, $idUtilisateur){
    $sql = "INSERT INTO 
                `media` 
                    (`titre`, `dateCreate`, `resume`, `utilisateur_id`) 
            VALUES 
                    ('" . $titre . "', CURRENT_TIME(), 
                    '" . $resume . "', ". $idUtilisateur .")";
    $messageSQL = changeBDD($sql, "media");
    return $messageSQL;
}

function addAMLink($idAuteur, $idMedia){
    $messageSQL = "";
    $sql = "SELECT 
                `id` 
            FROM 
                `auteur_media` 
            WHERE `idAuteur` = " . $idAuteur .
                " AND `idMedia` = " . $idMedia . ";";
    $result = selectBDD($sql);
    $nbRows = mysqli_num_rows($result);
    if( $nbRows === 0 && $idAuteur != 0 && $idMedia != 0){
        //traitement ajout d'un lien
        $sql = "INSERT INTO 
                `auteur_media` 
                    (`idAuteur`, `idMedia`) 
                VALUES 
                        (" . $idAuteur . ", " . $idMedia . ")";
        $messageSQL = changeBDD($sql, "auteur_media");
        return $messageSQL;
    }else{
        //$messageSQL = "ERREUR : <br />" . "<code>" . $sql . "</code>"
        $erreur = "";
        if($idMedia == 0 && $idAuteur == 0){
            $erreur = "Vous devez choisir un auteur ET un média";
        }elseif($idMedia == 0){
            $erreur = "Vous devez choisir un média";
        }else{
            $erreur = "Vous devez choisir un auteur";
        }
        return $messageSQL = "ERREUR : <br />" . "<code>" . utf8_decode($erreur) . "</code>";
    }
}

function createMediaSelect(){
    $sql = "SELECT * FROM `media` ORDER BY `titre`;";
    $result = selectBDD($sql);
    $nbRows = mysqli_num_rows($result);
    $selectMedia = "";
    $startSelect = "<label for=\"idMedia\" class=\"col-lg-4\">Média</label>"; //label du champ
    $startSelect .= "<select name=\"idMedia\" id=\"idMedia\" class=\"col-lg-8\" >"; //équivalent à $startSelect = $startSelect . 
    $selectOptions = "<option value=\"0\">Choisir un média</option>";
    $endSelect = "</select>";
    if($nbRows > 0){
        $i = 0;
        while($i < $nbRows){
            $row = mysqli_fetch_assoc($result);
            $selectOptions .= "<option value=\"" . $row["id"] . "\">";
            $selectOptions .= utf8_encode($row["titre"]);
            $selectOptions .= "</option>";
            $i++;
        }
    }
    $selectMedia = $startSelect . $selectOptions . $endSelect;
    return $selectMedia;
}

//fonctions sur les auteurs backoffice
function listAuteurBack($bdd){
    $listAuteur = "Liste auteur(s)";
    $sql = "SELECT 
                `a`.`id` AS `idAuteur`, 
                CONCAT(`a`.`nom`, ' ', `a`.`prenom`) AS `nomPrenom`, 
                count(`m`.`id`) AS `nbMedia`
                
            FROM 
                `auteur` `a` left join
                `auteur_media` `am` ON `a`.`id` = `am`.`idauteur` LEFT JOIN 
                `media` `m` ON `am`.`idmedia` = `m`.`id`
            GROUP BY 
                `a`.`id`
            ORDER BY 
                `nom`, `prenom`;";
    $response = $bdd->prepare($sql);
    $response->execute();
    $nbRows = $response->rowCount();
    $tabResult = "";
    $tabResult .= "<table class=\"table\">";
    $tabResult .= "<thead class=\"thead-dark\"><tr>";
    $tabResult .= "<th>Auteur</th><th>Livre(s) lié(s)</th><th colspan=\"2\">Actions</th>";
    $tabResult .= "</tr></thead>";
    $tabResult .= "<tbody>";
    while ($donnees = $response->fetch()) {
        $tabResult .= "<tr>";
        $tabResult .= "<td>" . $donnees["nomPrenom"] . "</td>";
        $tabResult .= "<td>" . $donnees["nbMedia"] . "</td>";
        $tabResult .= "<td>";
        $tabResult .= "<button class='btn btn-sm btn-outline-primary editAuteurButton' data-id='" .
            $donnees["idAuteur"] . "' data-toggle=\"modal\" data-target=\"#editAuteur\">";
        $tabResult .= "Editer</button> ";
        $tabResult .= "<td>";
        $tabResult .= "<a href=\"supEntite.php?entite=auteur&id=". $donnees["idAuteur"] ."\">Supprimer</a>";
        $tabResult .= "</td>";
        $tabResult .= "</tr>";
    }
    $tabResult .="</tbody>";
    $tabResult .= "</table>";
    $listAuteur = $tabResult;
    $response->closeCursor();
    return $listAuteur;
}

function addAuteur($nom, $prenom, $bio){
    $sql = "INSERT INTO 
                `auteur` 
                    (`nom`, `prenom`, `bio`) 
            VALUES 
                    ('" . $nom . "', '" . $prenom . "', '" . $bio . "')";
    $messageSQL = changeBDD($sql, "auteur");
    return $messageSQL;
}

function modMedia($titre, $resume, $idMedia, $bdd){
    $sql =  "UPDATE `media` SET ".
        " `titre` = :titre, ".
        " `resume` = :resume ".
        " WHERE `id` = :idMedia;";
    $response = $bdd->prepare( $sql);
    $response->execute(array(
        "idMedia" => htmlspecialchars( addslashes( $idMedia) ),
        "titre" =>  htmlspecialchars( addslashes( $titre )),
        "resume" => htmlspecialchars( addslashes( $resume ))
    ) );
    return $response;
}

function modAuteur($nom, $prenom, $bio, $idAuteur, $bdd){
    $sql =  "UPDATE `auteur` SET ".
                "`nom` = :nom, ".
                "`prenom` = :prenom, ".
                "`bio` = :bio ".
            "WHERE `id` = :idAuteur;";
    $response = $bdd->prepare( $sql);
    $response->execute(array(
        "idAuteur" => htmlspecialchars( addslashes( $idAuteur) ),
        "nom" =>  htmlspecialchars( addslashes( $nom )),
        "prenom" => htmlspecialchars( addslashes( $prenom )),
        "bio" => htmlspecialchars( addslashes( $bio ))
    ) );
    return $response;
}

function createAuthorSelect(){
    $sql = "SELECT * FROM `auteur` ORDER BY `nom`, `prenom`;";
    $result = selectBDD($sql);
    $nbRows = mysqli_num_rows($result);
    $selectAuthor = "";
    $startSelect = "<label for=\"idAuteur\" class=\"col-lg-4\">Auteur</label>"; //label du champ
    $startSelect .= "<select name=\"idAuteur\" id=\"idAuteur\" class=\"col-lg-8\" >"; //équivalent à $startSelect = $startSelect . 
    $selectOptions = "<option value=\"0\">Choisir un auteur</option>";
    $endSelect = "</select>";
    if($nbRows > 0){
        $i = 0;
        while($i < $nbRows){
            $row = mysqli_fetch_assoc($result);
            $selectOptions .= "<option value=\"" . $row["id"] . "\">";
            $selectOptions .= utf8_encode($row["prenom"]) . " " . utf8_encode($row["nom"]) ;
            $selectOptions .= "</option>";
            $i++;
        }
    }
    $selectAuthor = $startSelect . $selectOptions . $endSelect;
    return $selectAuthor;
}

//fonctions backoffice 
function deleteEntite($entite, $idEntite){
    //il faut supprimer en cascade les liens auteur_media existants
    if($entite === "media"){
        $colonne = "idmedia";
    }elseif($entite === "auteur"){
        $colonne = "idauteur";
    }
    $sqlKillLinks = "DELETE FROM `auteur_media` WHERE `" . $colonne . "` = ".$idEntite.";";
    //echo $sqlKillLinks."<br />";
    $sql = "DELETE FROM `" . $entite . "` WHERE `" . $entite . "`.`id` = ".$idEntite.";";
    //echo $sql."<br />";
    $test = changeBDD($sqlKillLinks, "auteur_media");
    //echo $test;
    return changeBDD($sql, $entite);

}

//fonctions pour les utilisateurs backoffice

function getAuthentication($email, $password, $bdd){
    $sql = "SELECT 
        * 
    FROM 
        `utilisateur` 
    WHERE 
        `email` liKE '" . $email . 
        "' AND `motdepasse` LIKE '" . $password . "';";
        $response = $bdd->prepare($sql);
        $response->execute();
        
    $response = $bdd->prepare($sql);
    $response->execute();
    $nbRows = $response->rowCount();
    if($nbRows > 0){
        $donnees = $response->fetch();
        $idUtilisateur = $donnees["id"];
        $nom = $donnees["nom"];
        $prenom = $donnees["prenom"];
        $email = $donnees["email"];
        $pseudo = $donnees["pseudo"];
        return connectUser($nom, $prenom, $email, $pseudo, $idUtilisateur);
    }else{
        return false;
    }
}

function connectUser($nom, $prenom, $email, $pseudo, $idUtilisateur){
    /*
    si arrivée sur le site sans connexion $connMode = "front" et donc test des cookies pour la connexion
    si arrivée sur le site via page de connexion $connMode = "back"
    */

        //traitement création des cookies et de la sessions
        setcookie("accesAdmin20200727", true, time() + 3600*24*30*12, "/" );
        setcookie("utilisateurEmail20200727", $email, time() + 3600, "/" );
        setcookie("utilisateurId20200727", $idUtilisateur, time()+ 3600, "/" );
        setcookie("utilisateurNom20200727", $nom, time() + 3600, "/" );
        setcookie("utilisateurPrenom20200727", $prenom, time() + 3600, "/" );
        setcookie("utilisateurPseudo20200727", $pseudo, time() + 3600, "/" );

        $_SESSION["accesAdmin20200727"] = true;
        $_SESSION["utilisateurId20200727"] = $idUtilisateur;
        $_SESSION["utilisateurEmail20200727"] = $email;
        $_SESSION["utilisateurNom20200727"] = $nom;
        $_SESSION["utilisateurPrenom20200727"] = $prenom;
        $_SESSION["utilisateurPseudo20200727"] = $pseudo;

    return true;
}

function destroyCookie(){

    unset($_COOKIE["accesAdmin20200727"]);
    unset($_COOKIE["utilisateurId20200727"]);
    unset($_COOKIE["utilisateurEmail20200727"]);
    unset($_COOKIE["utilisateurNom20200727"]);
    unset($_COOKIE["utilisateurPrenom20200727"]);
    unset($_COOKIE["utilisateurPseudo20200727"]);

    setcookie("accesAdmin20200727", "", time() - 3600, "/");
    setcookie("utilisateurEmail20200727", "", time() - 3600, "/" );
    setcookie("utilisateurId20200727", "", time() - 3600, "/" );
    setcookie("utilisateurNom20200727", "", time() - 3600, "/" );
    setcookie("utilisateurPrenom20200727", "", time() - 3600, "/" );
    setcookie("utilisateurPseudo20200727", "", time() - 3600, "/" );
}

?>
