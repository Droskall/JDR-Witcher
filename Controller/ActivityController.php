<?php


namespace App\Controller;


use App\Color;
use Exception;
use Model\Entity\Activity;
use Model\Manager\ActivityManager;
use Model\Manager\StickerManager;

class ActivityController extends AbstractController
{

    public function default()
    {
        self::render('home');
    }

    /**
     * Add a new activity.
     */
    public function add(){

        if(isset($_POST["title"]) && strlen($_POST["title"]) > 255){
            $_SESSION['error'] = ['Merci de respecter la limite du titre (255 caractères)'];
            header("Location: index.php?c=profile");
            exit();
        }
        else{
            if($activity = $this->checkData($_POST['category-type'], $_POST['activity-type'], $_POST['title'],
                $_POST['content'], $_FILES['url'], 'profile')){

                $activityManager = new ActivityManager();

                if(isset($_FILES['picture']) && $_FILES['picture']['error'] === 0){
                    if((int)$_FILES['picture']['size'] <= (3 * 1024 * 1024)){ // maximum size = 3 mo
                        $tmp_name = $_FILES['picture']['tmp_name'];
                        $name = $this->randomName($_FILES['picture']['name']);
                        $activity->setImage($name);
                        move_uploaded_file($tmp_name, 'uploads/' . $name);
                    }
                    else{
                        $_SESSION['error'] = ["L'image sélectionnée est trop grande"];
                        header("Location: index.php?c=profile");
                        exit();
                    }
                }

                if(isset($_FILES['url']) && $_FILES['url']['error'] === 0){
                    if((int)$_FILES['url']['size'] <= (7 * 1024 * 1024)){ // maximum size = 7 mo
                        $tmp_name = $_FILES['url']['tmp_name'];

                        $name = $this->randomName($_FILES['url']['name']);
                        $activity->setLink($name);
                        move_uploaded_file($tmp_name, 'uploads_pdf/' . $name);
                    }
                    else{
                        $_SESSION['error'] = ["Le document sélectionné est trop grand"];
                        header("Location: index.php?c=profile");
                        exit();
                    }

                }

                $id = $activityManager->addActivity($activity);
                header("Location: index.php?c=activity&a=show-activity&id=" . $id);
            }
        }
        $this->render('profile');
    }

    /**
     * Displays the activity that has a certain id
     * @param int $id
     */
    public function showActivity(int $id){
        $activityManager = new ActivityManager();

        $activity = $activityManager->getById($id);

        if ($activity === null) {
            self::default();
            exit();
        }

        $stickerManager = new StickerManager();
        $interaction = [
            'dead' => $stickerManager->countInteractionsByType('activity_id', $id, 'dead'),
            'fail' => $stickerManager->countInteractionsByType('activity_id', $id, 'fail'),
            'success' => $stickerManager->countInteractionsByType('activity_id', $id, 'success'),
            'epic' => $stickerManager->countInteractionsByType('activity_id', $id, 'epic'),
            'heart' => $stickerManager->countInteractionsByType('activity_id', $id, 'heart'),
        ];

        $userChoice = null;

        if (isset($_SESSION['user'])) {
            $userChoice = $stickerManager->hasAlreadyReacted($id, $_SESSION['user']->getId());
            $userChoice = $userChoice ? $userChoice['type'] : null;
        }

        $color = Color::getColor($activity->getCategory());

        self::render('activity', $data = [
            'activity' => $activity,
            'interaction' => $interaction,
            'userChoice' => $userChoice,
        ], $color);
    }

    /**
     * @param string $currentName
     * @return string
     */
    function randomName (string $currentName): string {
        $infos = pathinfo($currentName);
        return self::randomChars() . '.' . $infos['extension'];
    }

    /**
     * delete activity
     * @param int $id
     * @param $pg
     */
    public function delAct (int $id, string $pg){
        $activityManager = new ActivityManager();
        $activityManager->deleteActivity($id);
        header('Location: /index.php?c=category&a=get-category&name=' . $pg . '&type');
    }

    /**
     * update activity with new data
     * @param int $id
     */
    public function upAct (int $id){
        if(isset($_POST["title"]) && strlen($_POST["title"]) > 255){
            $_SESSION['error'] = ['Merci de respecter la limite du titre (255 caractères)'];
            header("Location: index.php?c=activity&a=actToUpdate&id=" . $id);
            exit();
        }
        else {
            $activityManager = new ActivityManager();

            if($activity = $this->checkData($_POST['category-type'], $_POST['activity-type'], $_POST['title'],
                $_POST['content'], $_FILES['url'], 'activity&a=actToUpdate&id=' . $id, $activityManager->getById($id)->getImage())){

                if(isset($_FILES['picture']) && $_FILES['picture']['error'] === 0){
                    if((int)$_FILES['picture']['size'] <= (3 * 1024 * 1024)){ // maximum size = 3 mo
                        $tmp_name = $_FILES['picture']['tmp_name'];
                        $name = $activity->getImage() === "activity-placeholder.png" ?
                            $this->randomName($_FILES['picture']['name']) : $activity->getImage();

                        $activity->setImage($name);
                        move_uploaded_file($tmp_name, 'uploads/' . $name);
                    }
                    else{
                        $_SESSION['error'] = ["L'image sélectionnée est trop grande"];
                        header("Location: index.php?c=activity&a=actToUpdate&id=" . $id);
                        exit();
                    }
                }

                if(isset($_FILES['url']) && $_FILES['url']['error'] === 0){
                    if((int)$_FILES['url']['size'] <= (7 * 1024 * 1024)){ // maximum size = 7 mo
                        $tmp_name = $_FILES['url']['tmp_name'];
                        $name = $activity->getLink() === null ?
                            $this->randomName($_FILES['url']['name']) : $activity->getLink();

                        $activity->setLink($name);
                        move_uploaded_file($tmp_name, 'uploads_pdf/' . $name);
                    }
                    else{
                        $_SESSION['error'] = ["Le document sélectionné est trop grand"];
                        header("Location: index.php?c=activity&a=actToUpdate&id=" . $id);
                        exit();
                    }
                }

                $id = $activityManager->updateActivity($activity, $id);
                header("Location: index.php?c=activity&a=show-activity&id=" . $id);
            }
        }
    }

    /**
     * @param $category
     * @param $activity
     * @param $title
     * @param $content
     * @param $url
     * @param $redirect
     * @param null $image
     * @return Activity|null
     */
    private function checkData($category, $activity, $title, $content, $url, $redirect, $image = null){
        if(isset($category, $activity, $title, $content, $url)){

            if (strlen($title) < 1 || strlen($content) < 1) {
                $_SESSION['error'] = ["Veuillez renseigner tous les champs requis"];
                header('Location: /index.php?c=' . $redirect);
                exit();
            }

            $category = htmlentities($category);
            $type = htmlentities($activity);
            $title = htmlentities($title);
            $content = htmlentities($content);

            $link = empty($url) ? null : htmlentities($url);

            $image = $image === null ? 'logo.png' : $image;

            return new Activity(null,$category, $type , $title, $content, $link, $image);
        }
        return null;
    }

    /**
     * display form of activity to update
     * @param int $id
     */
    public function actToUpdate (int $id) {
        $activityManager = new ActivityManager();
        $this->render('updateActivity', $data =
            ['activity' => $activityManager->getById($id)]
        );
    }

}