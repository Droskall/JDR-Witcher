<?php


namespace App\Controller;


use App\Color;
use App\Config;
use Model\Entity\link;
use Model\Manager\LinkManager;

class ToolboxController extends AbstractController
{
    /**
     *
     */
    public function default()
    {
        $this->render('toolbox', null, $color = Color::getColor('utile'));
    }

    /**
     * add a new link
     */
    public function addLink() {
        // connected & isset ?
        $this->checkIssetData($_SESSION['user'], $_POST['add-link'], $_POST['link-type'], $_POST['title'], $_POST['new-url']);

        if ($_SESSION['user']->getRole() !== 'admin') {
            self::default();
            exit();
        }

        // empty ?
        $this->checkEmptyData($_POST['link-type'], $_POST['title'], $_POST['new-url']);

        // filter sanitize
        $url = $this->cleanData($_POST['new-url']);

        $title = strip_tags($_POST['title']);

        // allowed link type ?
        $type = $this->linkInConfig($_POST['link-type']);

        $linkManager = new LinkManager();
        $linkManager->addLink($url, $type, $title);

        $links = $linkManager->getLinkByType($type);

        $color = Color::getColor('utile');

        self::render('linkList', $data = [
            'links' => $links,
            'type' => $type,
            ], $color);
    }

    /**
     * @param int $id
     */
    public function upLink(int $id){
        // connected & isset ?
        $this->checkIssetData($_SESSION['user'], $_POST['add-link'], $_POST['link-type'], $_POST['title'], $_POST['new-url']);

        if ($_SESSION['user']->getRole() !== 'admin') {
            self::default();
            exit();
        }

        // empty ?
        $this->checkEmptyData($_POST['link-type'], $_POST['title'], $_POST['new-url']);

        // filter sanitize
        $url = $this->cleanData($_POST['new-url']);

        $title = strip_tags($_POST['title']);

        // allowed link type ?
        $type = $this->linkInConfig($_POST['link-type']);

        $linkManager = new LinkManager();
        $linkManager->updateLink($id, $url, $type, $title);

        header("Location: index.php?c=toolbox&a=list&type=$type");
    }

    /**
     * @param int $id
     * @return void
     */
    public function delUrl(int $id){

        if ($_SESSION['user']->getRole() !== 'admin') {
            self::default();
            exit();
        }

        $linkManager = new LinkManager();
        $linkManager->deleteLink($id);

        $this->render('toolbox', null, $color = Color::getColor('utile'));
    }

    /**
     * get links by type
     * @param string $type
     */
    public function list(string $type) {

        // allowed link type ?
        if (!in_array($type, Config::LINK_TYPE)) {
            self::default();
            exit();
        }

        $color = Color::getColor('utile');
        $linkManager = new LinkManager();
        $links = $linkManager->getLinkByType($type);
        $item = $type === 'health' ? 'Santé' : ($type === 'mobility' ? 'Mobilité' : ($type === 'help' ? 'Aide' : 'formation' ));
        self::render('linkList', $data = [
            'type' => $item,
            'links' => $links
        ], $color);
    }

    /**
     * @param mixed ...$param
     */
    private function checkIssetData(...$param){
        foreach ($param as $item){
            if(!isset($item)){
                self::default();
                exit();
            }
        }
    }

    /**
     * @param mixed ...$param
     */
    private function checkEmptyData(...$param){
        foreach ($param as $item){
            if(empty($item)){
                $_SESSION['error'] = ["Tous les champs doivent être renseignés"];
                self::render('profile');
                exit();
            }
        }
    }

    /**
     * @param string $newUrl
     * @return mixed
     */
    private function cleanData(string $newUrl){
        $url = filter_var($newUrl, FILTER_SANITIZE_URL);
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * @param string $linkType
     * @return string
     */
    private function linkInConfig (string $linkType){
        if(!in_array($linkType, Config::LINK_TYPE)){
            self::default();
            exit();
        }
        return $linkType;
    }

    /**
     * @param int $id
     */
    public function linkToUpdate(int $id){
        $linkManager = new LinkManager();
        $this->render('updateLink', $data = [ 'link' => $linkManager->getLinkById($id)]);
    }
}
