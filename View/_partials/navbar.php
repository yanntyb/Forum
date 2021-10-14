<link rel="stylesheet" href="/View/assets/navbar.css">
<div id="navbar">
    <a href="/index.php">Accueil</a>
    <a href="/index.php?page=category">Categories</a>
    <?php
    if(isset($_SESSION["user"])){?>
        <a href="?page=deco">Déconnexion</a>
        <a href="?page=profile">Profile</a>
        <?php
    }
    else{?>
        <a href="?page=login">Connexion</a><?php
    }
    ?>

</div>