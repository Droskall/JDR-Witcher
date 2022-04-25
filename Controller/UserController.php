<?php


namespace App\Controller;

use Model\Manager\UserManager;

class UserController extends AbstractController
{
    /**
     * user list
     */
    public function default()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php');
        }
        if ($_SESSION['user']->getRole() !== 'admin') {
            header('Location: index.php');
        }

        $data = [];
        $userManager = new UserManager();
        $users = $userManager->getAll();
        foreach ($users as $user){
            $data[] = $user;
        }
        self::render('userList', $data);
    }

    public function update(){

        $data = [];
        $userManager = new UserManager();
        $users = $userManager->getAll();
        foreach ($users as $user){
            $data[] = $user;
        }

        $userManager->modifUserRole($_POST["userRole"], $_POST["id"]);

        self::render('userList', $data);
    }

    public function delete(){

        $data = [];
        $userManager = new UserManager();
        $users = $userManager->getAll();
        foreach ($users as $user){
            $data[] = $user;
        }

        if ($userManager->getById($_POST["id"])->getRole() === 'admin') {
            if ($userManager->isLastAdmin() === '1') {
                $_SESSION['error'] =  ["Vous ne pouvez pas supprimer ce compte tant qu'un autre admin n'a pas été créé"];
                self::render('userList', $data);
                exit();
            }
        }

        $userManager->deleteUser($_POST["id"]);

        self::render('profile', $data);
    }

    public function deleteself(){

        $userManager = new UserManager();
        if ($userManager->isLastAdmin() === '1') {
            $_SESSION['error'] =  ["Vous ne pouvez pas supprimer votre compte tant qu'un autre admin n'a pas été créé"];
            header('Location: /index.php?c=profile');
            exit();
        }

        $userManager->deleteUser($_SESSION['user']->getId());

        header('Location: index.php?c=connection&a=logout');
    }
}