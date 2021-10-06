<link rel="stylesheet" href="View/assets/navbar.css">
<div id="navbar">
    <a href="index.php">Accueil</a>
    <?php
    if(isset($_SESSION["user"])){?>

        <a href="?page=deco">Déconnexion</a><?php
    }
    else{?>
        <a href="?page=login">Connexion</a><?php
    }
    ?>

</div>