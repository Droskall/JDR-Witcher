<?php

namespace App\Controller;

use App\Config;
use Model\Manager\StickerManager;

class StickerController extends AbstractController
{

    public function default()
    {
        self::render('home');
    }

    /**
     * Add a new sticker
     * @param int $id
     * @param string $type
     */
    public function add(int $id, string $type) {
        if (!isset($_SESSION['user'])) {
            self::default();
            exit();
        }

        $type = strip_tags($type);

        if (!in_array($type, Config::STICKER_TYPE)) {
            self::default();
            exit();
        }

        $stickerManager = new StickerManager();
        $stickerManager->addSticker($type, $_SESSION['user']->getId(), $id);

        header('Location: /index.php?c=activity&a=show-activity&id=' . $id);
    }

    /**
     * delete a sticker
     * @param int $id
     */
    public function delete(int $id) {
        if (!isset($_SESSION['user'])) {
            self::default();
            exit();
        }

        $stickerManager = new StickerManager();
        $stickerManager->deleteSticker($_SESSION['user']->getId(), $id);

        header('Location: /index.php?c=activity&a=show-activity&id=' . $id);
    }

    public function update(int $id, string $type) {
        if (!isset($_SESSION['user'])) {
            self::default();
            exit();
        }

        $type = strip_tags($type);

        if (!in_array($type, Config::STICKER_TYPE)) {
            self::default();
            exit();
        }

        $stickerManager = new StickerManager();
        $stickerManager->updateSticker($type, $_SESSION['user']->getId(), $id);

        header('Location: /index.php?c=activity&a=show-activity&id=' . $id);
    }
}