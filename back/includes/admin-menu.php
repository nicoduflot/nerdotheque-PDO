<header>
    <h1>Admin Médiatèque</h1>
    <nav>
        <ul class="nav justify-content-left">
            <?php 
            if(!isset($_COOKIE["accesAdmin20200727"])){
                ?>
                <li class="nav-item"><a class="nav-link" href="./connexion.php">Connexion</a></li>
                <?php
            }else{
                ?>
                <li class="nav-item"><a class="nav-link" href="../index.php">Retour Médiathèque</a></li>
                <li class="nav-item"><a class="nav-link" href="./index.php">Tableau de bord</a></li>
                <li class="nav-item"><a class="nav-link" href="./addMedia.php">Ajout d'un média</a></li>
                <li class="nav-item"><a class="nav-link" href="./addAuteur.php">Ajout d'un auteur</a></li>
                <li class="nav-item"><a class="nav-link" href="./addAMLink.php">Lier auteur - media</a></li>
                <li class="nav-item"><a class="nav-link" href="./deconnexion.php">Déconnexion</a></li>
                <?php
            }
            //print_r(var_dump($_COOKIE));
            ?>
            
        </ul>
    </nav>
</header>
