function loaded(callable){document.addEventListener("DOMContentLoaded", callable);}
function $(selector){return document.querySelector(selector);}
function $$(selector){return document.querySelectorAll(selector);}

var eventClickMouse = new MouseEvent('click', {
    'view': window,
    'bubbles': true,
    'cancelable': true
});

loaded(function(){
    //ouvrir la modal de modification du media
    $$(".editMediaButton").forEach(function(mediaLine){
        mediaLine.addEventListener("click", function (){
            fetch('./includes/ajaxModMedia.php?idMedia='+this.dataset.id)
            .then(response => response.json())
            .then( (json) => {
                //console.log(json);
                $("#titre").value = json["titre"];
                $("#resume").value = json["resume"];
                $("#idMedia").value = json["idMedia"];
                $("#idUtilisateur").value = json["idUtilisateur"];
            })
            .catch(error => console.log("Erreur : " + error));
        });
    });
    //valider la modification et modifier le media
    $("#submitModMedia").addEventListener("click", function (e){
        e.preventDefault();
        let parametres = {
                modMedia: "mod",
                idMedia: $("#idMedia").value,
                titre: $("#titre").value,
                resume: $("#resume").value
            };
        console.log(JSON.stringify(parametres));
        fetch('./includes/ajaxModMedia.php',{
            method: 'POST',
            body: JSON.stringify(parametres)
        }).then(res => {
            //console.log("Request complete", res);
        }).catch(function(error){
            //console.log("Request success", error);
        });
        //console.log("the submit is paused until the modification is passed");
    })
    //ouvrir la modal de modification de l'auteur
    $$(".editAuteurButton").forEach(function(auteurLine){
        auteurLine.addEventListener("click", function (){
            //console.log('./includes/ajaxModAuteur.php?idAuteur='+this.dataset.id);
            fetch('./includes/ajaxModAuteur.php?idAuteur='+this.dataset.id)
                .then(response => response.json())
                .then( (json) => {
                    //console.log(json);
                    $("#nom").value = json["nom"];
                    $("#prenom").value = json["prenom"];
                    $("#bio").value = json["bio"];
                    $("#idAuteur").value = json["idAuteur"];
                })
                .catch(error => console.log("Erreur : " + error));
        });
    });
    //valider la modification et modifier l'auteur
    $("#submitModAuteur").addEventListener("click", function (e){
        e.preventDefault();
        let parametres = {
            modAuteur: "mod",
            idAuteur: $("#idAuteur").value,
            nom: $("#nom").value,
            prenom: $("#prenom").value,
            bio: $("#bio").value
        };
        console.log(JSON.stringify(parametres));
        fetch('./includes/ajaxModAuteur.php',{
            method: 'POST',
            body: JSON.stringify(parametres)
        }).then(res => {
            //console.log("Request complete", res);
        }).catch(function(error){
            //console.log("Request success", error);
        });
        //console.log("the submit is paused until the modification is passed");
    })
});
