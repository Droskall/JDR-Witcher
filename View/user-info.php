<div class="flex white connection_register" id="contains">
    <form id="change_email_username" action="/index.php?c=profile&a=change-mail-name" method="post">
        <h2>Email / Username</h2>
        <input type="email" name="email" value="<?= $data['user']->getEmail() ?>">
        <input type="text" name="username" value="<?= $data['user']->getUsername() ?>">
        <input type="password" placeholder="Votre mot de passe" name="password">

        <input type="submit" name="submit" value="changer">
    </form>

    <form id="change_password" action="/index.php?c=profile&a=change-password" method="post">
        <h2>Mot de passe</h2>
        <input type="password" placeholder="Nouveau mot de passe" name="password">
        <input type="password" placeholder="Nouveau mot de passe" name="passwordRepeat">
        <input type="password" placeholder="Ancien mot de passe" name="oldPassword">

        <input type="submit" name="submit" value="changer">
    </form>

</div>
