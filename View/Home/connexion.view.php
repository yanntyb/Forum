<link rel="stylesheet" href="View/assets/connect.css">
<div id="main">
    <div>
        <h2>Connexion</h2>
        <form action="index.php?page=checkLog" method="post">
            <div>
                <input name="name" type="text" placeholder="username">
            </div>
            <div>
                <input name="pass" type="password" placeholder="password">
            </div>
            <div>
                <input type="submit">
            </div>
        </form>
    </div>
    <div>
        <h2>Inscription</h2>
        <form action="index.php?page=checkRegister" method="post">
            <div>
                <input name="name" type="text" placeholder="username">
            </div>
            <div>
                <input name="pass" type="password" placeholder="password">
            </div>
            <div>
                <input name="pass_verif" type="password" placeholder="password">
            </div>
            <div>
                <input type="submit">
            </div>
        </form>
    </div>
</div>
