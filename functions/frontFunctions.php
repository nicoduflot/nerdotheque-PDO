<?php
// fonctions pour les media front
function listMedia($bdd){
    $sql = "SELECT `id` AS `idMedia`, `titre` AS `titreMedia` FROM `media` ORDER BY `titre`";
    $response = $bdd->prepare($sql);
    $response->execute();
    $nbRows = $response->rowCount();
    $tabResult = "";
    $tabResult .= "<table class=\"table\">";
    $tabResult .= "<thead class=\"thead-dark\"><tr>";
    $tabResult .= "<th>Titre</th>";
    $tabResult .= "</tr></thead>";
    $tabResult .= "<tbody>";
    while ($donnees = $response->fetch()){
        $tabResult .= "<tr>";
        $tabResult .= "<td>".
            "<a href=\"media.php?idMedia=" . $donnees["idMedia"] .
            "\">" . $donnees["titreMedia"] . "</a></td>";
        $tabResult .= "</tr>";
    }
    $tabResult .="</tbody>";
    $tabResult .= "</table>";
    $listeMedia = $tabResult;
    $response->closeCursor();
    return $listeMedia;
}

function afficheMedia($idMedia, $bdd){
    //$conditions = "`m`.`id` = " . htmlspecialchars(addslashes($idMedia));
    $conditions = "WHERE `m`.`id` = :idMedia";
    $sql = "SELECT
                `m`.`id`,`m`.`utilisateur_id`, `m`.`titre`, `m`.`dateCreate`, `m`.`resume`, 
                CONCAT(`a`.`prenom`, ' ', `a`.`nom`) AS `prenomNom`, `a`.`id` AS `idAuteur`
                
            FROM 
                `media` `m` LEFT JOIN 
                `auteur_media` `am` ON `m`.`id` = `am`.`idmedia` LEFT JOIN 
                `auteur` `a` ON `am`.`idauteur` = `a`.`id` " . $conditions;
    $response = $bdd->prepare( $sql);
    $response->execute(array( "idMedia" => htmlspecialchars( addslashes( $idMedia) ) ) );
    return $response;
}

//fonctions pour les auteurs front
function listAuteur($bdd){
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
    $response = $bdd->prepare($sql);
    $response->execute();
    $nbRows = $response->rowCount();
    $tabResult = "";
    $tabResult .= "<table class=\"table\">";
    $tabResult .= "<thead class=\"thead-dark\"><tr>";
    $tabResult .= "<th>Auteur</th><th>Livre(s) lié(s)</th>";
    $tabResult .= "</tr></thead>";
    $tabResult .= "<tbody>";
    while ($donnees = $response->fetch()){
        $tabResult .= "<tr>";
        $tabResult .= "<td><a href=\"auteur.php?idAuteur=" . $donnees["idAuteur"] . "\">" .
            $donnees["nomPrenom"] . "</a></td>";
        $tabResult .= "<td>" . $donnees["nbMedia"] . "</td>";
        $tabResult .= "</tr>";
    }
    $tabResult .="</tbody>";
    $tabResult .= "</table>";
    $listAuteur = $tabResult;
    $response->closeCursor();
    return $listAuteur;
}

function afficheAuteur($idAuteur, $bdd){
    $conditions = " WHERE `a`.`id` = :idAuteur ";
    $sql = "SELECT 
                `a`.`id`, CONCAT(`a`.`prenom`, ' ', `a`.`nom`) AS `prenomNom`, `a`.`bio`,
                `m`.`titre`, `m`.`id` AS `idMedia` 
            FROM 
                `auteur` `a` left join
                `auteur_media` `am` ON `a`.`id` = `am`.`idauteur` LEFT JOIN 
                `media` `m` ON `am`.`idmedia` = `m`.`id` " . $conditions . 
            " ORDER BY `m`.`titre`;";
            // . htmlspecialchars(addslashes($idAuteur))
    $response = $bdd->prepare( $sql);
    $response->execute(array( "idAuteur" => htmlspecialchars( addslashes( $idAuteur) ) ) );
    return $response;
}

