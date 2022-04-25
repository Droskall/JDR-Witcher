<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Witcher JDR</title>
</head>
<body>
<header>
    <?php

    use Model\Entity\User;

    if (isset($_SESSION['error'])) {
    ?>
        <div class="error">
    <?php
        foreach ($_SESSION['error'] as $value) {
        ?>
            <p><?= $value ?></p>
        <?php
        }
    ?>
            <button id="close">x</button>
        </div>
    <?php
        unset($_SESSION['error']);
    }
    ?>
    <div>
        <a href="/index.php">
            <img src="/assets/img/logo.png" alt="logo">
        </a>
        <span>Witcher JDR</span>
        <?php
        if (isset($_SESSION['user'])) {?>
        <a href="/index.php?c=profile" id="logoUser">
            <img src="/assets/img/avatar/<?= $_SESSION['user']->getAvatar() ?>" alt="avatar">
        </a>
            <a class="menu" href="/index.php?c=connection&a=logout" id="logout"><i class="fas fa-sign-out-alt"></i></a>
        <?php } else{?>
            <a href="/index.php?c=connection" id="logoUser"><img src="/assets/img/blueUser.png" alt=""></a>
        <?php }?>

    </div>
    <nav>
        <span class="menu"><i class="fas fa-bars"></i></span>
        <div class="menu">
            <ul>
                <li><a href="/index.php">Accueil</a></li>
                <li><a href="/index.php?c=category&a=get-category&name=help&type">Aide de jeu</a></li>
                <li><a href="/index.php?c=category&a=get-category&name=resource&type">Ressource</a></li>
                <li><a href="/index.php?c=category&a=get-category&name=utils&type">Outils</a></li>
                <li><a href="/index.php?c=toolbox">Liens</a></li>
            </ul>
        </div>
    </nav>
</header>

<main><?= $page ?></main>

<?php
if(!isset($color)) {
    $color = '#aeaeae';
}
?>
<footer style="background-color: <?= $color ?>">
    <div class="flex">
        <div>
            <h3>Nous contacter</h3>
            <address></address>
        </div>

        <div>
            <h3>Nous suivre</h3>
            <address></address>
            <address></address>
        </div>

        <div>
            <h3>Les Jeux de Role</h3>
            <p>Vendredi et Samedi de 20h30 à 00h00</p>
            <p>Dimanche de 13h30 à 17h30</p>
        </div>
    </div>

    <p>&copy</p>
</footer>

<script src="https://kit.fontawesome.com/25d98733ec.js" crossorigin="anonymous"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>
