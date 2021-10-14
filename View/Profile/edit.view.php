<link rel="stylesheet" href="/View/assets/create.css">
<div id="main">
    <div>
        <form action="/?page=edit&type=profile" method="post">
            <div>
                <h2>Ancien Nom</h2>
                <input class="title" type="text" disabled value="<?= $var->getName() ?>">

            </div>
            <div>
                <h2>Nouveau Nom</h2>
                <input class="title" required name="name" type="text">
            </div>
            <div>
                <h2>Changement de mot de pass</h2>
                <input name="oldPass" class="title" type="password" placeholder="Ancien mot de passe">
                <input name="newPass" class="title" type="password" placeholder="Nouveau mot de passe">
                <input name="newPassConfirme" class="title" type="password" placeholder="Confirmation nouveau mot de passe">
            </div>
            <input type="text" class="hidden" name="id" value="<?= $var->getId() ?>">
            <div id="submit">
                <input type="submit" value="Publier">
            </div>
        </form>
    </div>
</div>