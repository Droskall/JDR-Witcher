<?php


namespace App\Controller;


use App\Color;
use Model\Manager\ActivityManager;
use Model\Manager\StickerManager;
use Model\Manager\UserManager;

class CategoryController extends AbstractController
{
    public function default()
    {
        $this->render('home');
    }

    /**
     * get the activities by category name
     * @param string $name
     * @param string $type
     */
    public function getCategory(string $name, string $type = '') {

        $category = filter_var($name, FILTER_SANITIZE_STRING);
        $type = filter_var($type, FILTER_SANITIZE_STRING);

        $activityManager = new ActivityManager();
        $stickerManager = new StickerManager();

        $activities = $type === '' ? $activityManager->getActivitiesByCategory($category) : $activityManager->getByCategoryAndType($category, $type);
        $data = [];

        foreach ($activities as $value) {
            $data[] = [
                'activity' => $value,
                'interactions' => $stickerManager->countActivityInteractions($value->getId()),
            ];
        }
        $data += ['category' => $category];

        self::render('category', $data, Color::getColor($category));
    }
}