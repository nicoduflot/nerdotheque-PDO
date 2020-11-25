<header>
    <h1>Médiatèque</h1>
    <nav>
        <ul class="nav justify-content-left">
            <li class="nav-item"><a class="nav-link" href="./index.php">Home</a></li>
            <?php 
            if(!isset($_COOKIE["accesAdmin20200727"])){
                ?>
                <li class="nav-item"><a class="nav-link" href="./back/connexion.php">Connexion</a></li>
                <?php
            }else{
                ?>
                <li class="nav-item"><a class="nav-link" href="./back/index.php">Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="./back/deconnexion.php">Déconnexion</a></li>
                <?php
            }
            //print_r(var_dump($_COOKIE));
            ?>
        </ul>
    </nav>
</header>
