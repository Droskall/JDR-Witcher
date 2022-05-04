<?php

require __DIR__ . "/Config.php";
require __DIR__ . "/Color.php";

require __DIR__ . "/Model/Entity/Activity.php";
require __DIR__ . "/Model/Entity/User.php";
require __DIR__ . "/Model/Entity/Sticker.php";
require __DIR__ . "/Model/Entity/link.php";

require __DIR__ . "/Model/DB.php";

require __DIR__ . "/Model/Manager/Traits/ManagerTrait.php";
require __DIR__ . "/Model/Manager/ActivityManager.php";
require __DIR__ . "/Model/Manager/UserManager.php";
require __DIR__ . "/Model/Manager/StickerManager.php";
require __DIR__ . "/Model/Manager/LinkManager.php";

require __DIR__ . "/Controller/AbstractController.php";
require __DIR__ . "/Controller/ErrorController.php";
require __DIR__ . "/Controller/HomeController.php";
require __DIR__ . "/Controller/ActivityController.php";
require __DIR__ . "/Controller/CategoryController.php";
require __DIR__ . "/Controller/ToolboxController.php";
require __DIR__ . "/Controller/ConnectionController.php";
require __DIR__ . "/Controller/ProfileController.php";
require __DIR__ . "/Controller/UserController.php";
require __DIR__ . "/Controller/StickerController.php";

require __DIR__ . "/Routeur.php";

session_start();