<?php

namespace App\Controller;

use App\Config;
use Model\Manager\UserManager;
use Model\Manager\Traits\ManagerTrait;

class ConnectionController extends AbstractController
{
    public function default()
    {
        $this->render('connection');
    }

    /**
     * register a new user
     */
    public function register()
    {
        if (!isset($_POST['submit'])) {
            self::default();
            exit();
        }

        if (!isset($_POST['email']) || !isset($_POST['username']) || !isset($_POST['password'])) {
            self::default();
            exit();
        }

        $data = self::checkMailUsernamePassword();

        if (count($data['error']) > 0) {
            $_SESSION['error'] = $data['error'];
            self::default();
            exit();
        }

        $mail = $data['mail'];
        $username = $data['username'];
        $password = $data['password'];

        $userManager = new UserManager();

        if ($userManager->getUser($mail) !== null) {
            $_SESSION['error'] = ['adresse mail déjà enregistré'];
            self::default();
            exit();
        }

        if (!preg_match('/^(?=.*[!@#$%^&*-\])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $password)) {
            $_SESSION['error'] = ["Le mot de passe n'est pas assez sécurisé"];
            self::default();
            exit();
        }

        if ($password === $_POST['passwordRepeat']) {

            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $token = self::randomChars();

            $user = $userManager->insertUser($mail, $username, $password, password_hash($token, PASSWORD_BCRYPT));

            if (self::registerMail($mail, $token, $username, $user->getId())) {

                self::render('connection', $data = ["Un email à été envoyé a l'adresse email renseignée,
                veuillez confirmer cette adresse afin de vous connecter à votre compte"]);
            } else {
                self::render('connection', $data = ["Une erreur c'est produite"]);
            }

        } else {
            $_SESSION['error'] = ["Les mot de passe ne corespondent pas"];
            self::default();
            exit();
        }
    }

    /**
     * Connect a user
     */
    public function connect()
    {
        if (!isset($_POST['submit'])) {
            self::default();
            exit();
        }

        if (!isset($_POST['email'], $_POST['password'])) {
            self::default();
            exit();
        }

        $mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $error = [];

        if (strlen($mail) < 8 || strlen($mail) >= 100) {
            $error[] = "l'adresse email doit faire entre 8 et 150 caractères";
        }

        $userManager = new UserManager();
        $user = $userManager->getUser($mail);

        if ($user === null) {
            $error[] = "L'utilisateur demandé n'est pas enregistré";
        }

        if (count($error) > 0) {
            $_SESSION['error'] = $error;
            self::default();
            exit();
        }

        if ($user->getRole() === 'none') {
            $_SESSION['error'] = ["Cette adresse mail n'a pas été vérifiée"];
            self::default();
            exit();
        }

        if (password_verify($_POST['password'], $user->getPassword())) {

            $user->setPassword('');
            $_SESSION['user'] = $user;

            self::render('home');

        } else {

            $_SESSION['error'] = ['Adresse mail ou mot de passe incorrect'];
            self::default();
            exit();
        }
    }

    /**
     * Disconnect
     * @return void
     */
    public function logout()
    {
        // We destroy the variables of our session.
        session_unset();
        // We destroy our session.
        session_destroy();
        self::render('home');
    }

    /**
     * @param string $userMail
     * @param $token
     * @param $username
     * @param $id
     * @return bool
     */
    private function registerMail(string $userMail, $token, $username, $id)
    {

        $url = Config::APP_URL . '/index.php?c=connection&a=activate&id=' . $id . '&token=' . $token;

        $message = "
        <html lang='fr'>
            <head>
                <title>Vérification de votre compte Witcher JDR</title>
            </head>
            <body>
                <span>Bonjour $username,</span>
                <p>
                    Afin de finaliser votre inscription sur le site Witcher-JDR, 
                    <br>
                    merci de cliquer <a href=\"$url\">sur ce lien</a> pour vérifier votre adresse email.
                </p>
            </body>
        </html>
        ";

        $to = $userMail;
        $subject = 'Vérification de votre adresse email';
        $headers = [
            'Reply-to' => "no-reply@email.com",
            'X-Mailer' => 'PHP/' . phpversion(),
            'Mime-version' => '1.0',
            'Content-type' => 'text/html; charset=utf-8'
        ];

        return mail($to, $subject, $message, $headers, "-f no-reply@email.com");
    }

    /**
     * go to activate-account
     */
    public function activate(int $id)
    {
        $userManager = new UserManager();
        $user = $userManager->getById($id);

        if ($user->getRole() !== 'none') {
            self::render('home');
            exit();
        }

        $userManager->modifUserRole('user', $id);
        self::render('activate');
    }

    /**
     * @return void
     */
    public function pswdForget()
    {
        self::render('passwordForget');
    }

    /**
     * @return void
     */
    public function newPswd()
    {
        if (!isset($_POST['submit'])) {
            self::default();
            exit();
        }

        if (!isset($_POST['email'])) {
            self::default();
            exit();
        }

        $data = self::checkMailUsernamePassword();

        if (count($data['error']) > 0) {
            $_SESSION['error'] = $data['error'];
            self::default();
            exit();
        }

        $mail = $data['mail'];
        $username = $data['username'];

        if (self::forgetPassword($mail, $username)){
            self::render('connection', $data = ["Un email à été envoyé a l'adresse email renseignée !"]);
        }
    }

    /**
     * @param string $userMail
     * @param $username
     * @return bool
     */
    private function forgetPassword(string $userMail, $username)
        {
            $password = uniqid();
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $useManager = new UserManager();
            $useManager->updatePasswordByMail($passwordHash, $userMail);

            $message = "
        <html lang='fr'>
            <head>
                <title>Changement de mot de passe pour votre compte Witcher-JDR</title>
            </head>
            <body>
                <span>Bonjour $username,</span>
                <p>
                    Bonjour, voici votre nouveau mot de passe : $password, 
                </p>
            </body>
        </html>
        ";

            $to = $userMail;
            $subject = 'Nouveau MDP';
            $headers = [
                'Reply-to' => "no-reply@email.com",
                'X-Mailer' => 'PHP/' . phpversion(),
                'Mime-version' => '1.0',
                'Content-type' => 'text/html; charset=utf-8'
            ];

            return mail($to, $subject, $message, $headers, "-f no-reply@email.com");
        }
}

