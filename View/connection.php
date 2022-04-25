<div class="flex white connection_register" id="contains">
    <form id="connection" action="/index.php?c=connection&a=connect" method="post">
        <h2>Connexion</h2>
        <input type="email" placeholder="Votre email" name="email" id="email">
        <input type="password" placeholder="Votre mot de passe" name="password" id="pswd">

        <input type="submit" name="submit" value="connexion" id="buttonC">

        <a href="/index.php?c=connection&a=pswd-forget">Mot de passe oublié ?</a>
    </form>

    <form id="register" action="/index.php?c=connection&a=register" method="post">
        <h2>Inscription</h2>
        <input type="email" placeholder="Votre email" name="email" id="emailInscript">
        <input type="text" placeholder="Votre pseudo" name="username" id="pseudoInscript">

        <input type="password" placeholder="Votre mot de passe" name="password" id="passwordInscript">
        <input type="password" placeholder="Répéter votre mot de passe" name="passwordRepeat" id="passwordConfirmInscript">

        <input type="submit" name="submit" value="inscription" id="buttonValidateI">
    </form>

    <?php
    if (isset($data))
        echo '<p>' . $data[0] . '</p>'
    ?>
</div>