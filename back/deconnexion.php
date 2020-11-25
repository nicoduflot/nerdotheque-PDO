<?php
    session_start();
    include "../functions/functions.php";
    include "../functions/sql.php";
    session_destroy();
    destroyCookie();
    //var_dump($_COOKIE);
    header("location: ../index.php");
?>
