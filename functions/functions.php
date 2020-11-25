<?php
/**
 * 
 * Page de fonctions dédiés à la formation
 * 
 */
// fonctions pour les media front

function listMedia(){
    $listeMedia = "Liste Média";
    $sql = "SELECT `id` AS `idMedia`, `titre` AS `titreMedia` FROM `media` ORDER BY `titre`";
    $result = selectBDD($sql);
    $nbRows = mysqli_num_rows($result);
    $tabResult = "";
    $tabResult .= "<table class=\"table\">";
    $tabResult .= "<thead class=\"thead-dark\"><tr>";
    $tabResult .= "<th>Titre</th>";
    $tabResult .= "</tr></thead>";
    $tabResult .= "<tbody>";
    if($nbRows > 0){
        $i = 0;
        while($i < $nbRows){
            $row = mysqli_fetch_assoc($result);
            $tabResult .= "<tr>";
            $tabResult .= "<td><a href=\"media.php?idMedia=" . $row["idMedia"] . "\">" . utf8_encode($row["titreMedia"]) . "</a></td>";
            $tabResult .= "</tr>";
            $i++;
        }
    }
    $tabResult .="</tbody>";
    $tabResult .= "</table>";
    $listeMedia = $tabResult;
    return $listeMedia;
}

function afficheMedia($idMedia){
    $sql = "SELECT
                `m`.`id`,`m`.`utilisateur_id`, `m`.`titre`, `m`.`dateCreate`, `m`.`resume`, 
                CONCAT(`a`.`prenom`, ' ', `a`.`nom`) AS `prenomNom`, `a`.`id` AS `idAuteur`
                
            FROM 
                `media` `m` LEFT JOIN 
                `auteur_media` `am` ON `m`.`id` = `am`.`idmedia` LEFT JOIN 
                `auteur` `a` ON `am`.`idauteur` = `a`.`id`
            WHERE 
                `m`.`id` = " . htmlspecialchars(addslashes($idMedia)) . ";";
    $result = selectBDD($sql);
    return $result;
}

//fonctions pour les auteurs front
function listAuteur(){
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
                `nom`, `prenom`";
    $result = selectBDD($sql);
    $nbRows = mysqli_num_rows($result);
    $tabResult = "";
    $tabResult .= "<table class=\"table\">";
    $tabResult .= "<thead class=\"thead-dark\"><tr>";
    $tabResult .= "<th>Auteur</th><th>Livre(s) lié(s)</th>";
    $tabResult .= "</tr></thead>";
    $tabResult .= "<tbody>";
    if($nbRows > 0){
        $i = 0;
        while($i < $nbRows){
            $row = mysqli_fetch_assoc($result);
            $tabResult .= "<tr>";
            $tabResult .= "<td><a href=\"auteur.php?idAuteur=" . $row["idAuteur"] . "\">" .
            utf8_encode($row["nomPrenom"]) . "</a></td>";
            $tabResult .= "<td>" . $row["nbMedia"] . "</td>";
            $tabResult .= "</tr>";
            $i++;
        }
    }
    $tabResult .="</tbody>";
    $tabResult .= "</table>";
    $listAuteur = $tabResult;

    return $listAuteur;
}

function afficheAuteur($idAuteur){
    $sql = "SELECT 
                `a`.`id`, CONCAT(`a`.`prenom`, ' ', `a`.`nom`) AS `prenomNom`, `a`.`bio`,
                `m`.`titre`, `m`.`id` AS `idMedia` 
            FROM 
                `auteur` `a` left join
                `auteur_media` `am` ON `a`.`id` = `am`.`idauteur` LEFT JOIN 
                `media` `m` ON `am`.`idmedia` = `m`.`id`
            WHERE 
                `a`.`id` = " . htmlspecialchars(addslashes($idAuteur)) . 
            " ORDER BY `m`.`titre`;";
    $result = selectBDD($sql);
    return $result;
}

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

function listMediaBack(){
    $listeMedia = "Liste Média";
    $sql = "SELECT `id` AS `idMedia`, `titre` AS `titreMedia` FROM `media` ORDER BY `titre`";
    $result = selectBDD($sql);
    $nbRows = mysqli_num_rows($result);
    $tabResult = "";
    $tabResult .= "<table class=\"table\">";
    $tabResult .= "<thead class=\"thead-dark\"><tr>";
    $tabResult .= "<th>Titre</th><th colspan=\"2\">Actions</th>";
    $tabResult .= "</tr></thead>";
    $tabResult .= "<tbody>";
    if($nbRows > 0){
        $i = 0;
        while($i < $nbRows){
            $row = mysqli_fetch_assoc($result);
            $tabResult .= "<tr>";
            $tabResult .= "<td>" . utf8_encode($row["titreMedia"]) . "</td>";
            $tabResult .= "<td>";
            $tabResult .= "<button class='btn btn-sm btn-outline-primary editMediaButton' data-id='" . $row["idMedia"] . "' data-toggle=\"modal\" data-target=\"#editMedia\">";
            $tabResult .= "Editer</button> ";
            //$tabResult .= "<a href=\"./modMedia.php?idMedia=" . $row["idMedia"] . "\">Editer</a>";
            $tabResult .= "</td>";
            $tabResult .= "<td>";
            $tabResult .= "<a href=\"supEntite.php?entite=media&id=". $row["idMedia"] ."\">Supprimer</a>";
            $tabResult .= "</td>";
            $tabResult .= "</tr>";
            $i++;
        }
    }
    $tabResult .="</tbody>";
    $tabResult .= "</table>";
    $listeMedia = $tabResult;
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

function modMedia($titre, $resume, $idMedia){
    $sql =  "UPDATE `media` SET ".
                "`titre` = '" . $titre ."', ".
                "`resume` = '" . $resume . "' ".
            "WHERE `id` = " . $idMedia . ";";
    $messageSQL = changeBDD($sql, "media");
    return $messageSQL;
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

function listAuteurBack(){
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
    $result = selectBDD($sql);
    $nbRows = mysqli_num_rows($result);
    $tabResult = "";
    $tabResult .= "<table class=\"table\">";
    $tabResult .= "<thead class=\"thead-dark\"><tr>";
    $tabResult .= "<th>Auteur</th><th>Livre(s) lié(s)</th><th colspan=\"2\">Actions</th>";
    $tabResult .= "</tr></thead>";
    $tabResult .= "<tbody>";
    if($nbRows > 0){
        $i = 0;
        while($i < $nbRows){
            $row = mysqli_fetch_assoc($result);
            $tabResult .= "<tr>";
            $tabResult .= "<td>" . utf8_encode($row["nomPrenom"]) . "</td>";
            $tabResult .= "<td>" . $row["nbMedia"] . "</td>";
            $tabResult .= "<td>";
            $tabResult .= "<button class='btn btn-sm btn-outline-primary editAuteurButton' data-id='" . $row["idAuteur"] . "' data-toggle=\"modal\" data-target=\"#editAuteur\">";
            $tabResult .= "Editer</button> ";
            //$tabResult .= "<a href=\"modAuteur.php?idAuteur=" . $row["idAuteur"] . "\">Editer</a></td>";
            $tabResult .= "<td>";
            $tabResult .= "<a href=\"supEntite.php?entite=auteur&id=". $row["idAuteur"] ."\">Supprimer</a>";
            $tabResult .= "</td>";
            $tabResult .= "</tr>";
            $i++;
        }
    }
    $tabResult .="</tbody>";
    $tabResult .= "</table>";
    $listAuteur = $tabResult;

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

function modAuteur($nom, $prenom, $bio, $idAuteur){
    $sql =  "UPDATE `auteur` SET ".
                "`nom` = '" . $nom ."', ".
                "`prenom` = '" . $prenom . "', ".
                "`bio` = '" . $bio . "' ".
            "WHERE `id` = " . $idAuteur . ";";
    $messageSQL = changeBDD($sql, "auteur");
    return $messageSQL;
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

function getAuthentication($email, $password){
    $sql = "SELECT 
                * 
            FROM 
                `utilisateur` 
            WHERE 
                `email` liKE '" . $email . 
                "' AND `motdepasse` like '" . $password . "';";
    $result = selectBDD($sql);
    $nbRows = (!$result)? 0 : mysqli_num_rows($result);
    if($nbRows > 0){
        $idUtilisateur = mysqli_fetch_assoc($result)["id"];
        $nom = mysqli_fetch_assoc($result)["nom"];
        $prenom = mysqli_fetch_assoc($result)["prenom"];
        $email = mysqli_fetch_assoc($result)["email"];
        $pseudo = mysqli_fetch_assoc($result)["pseudo"];
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
