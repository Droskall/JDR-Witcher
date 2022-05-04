<?php

namespace Model\Manager;

use Model\Entity\Activity;
use Model\Entity\Comment;
use Model\Entity\Sticker;
use Model\Manager\Traits\ManagerTrait;

class ActivityManager {

    use ManagerTrait;

    public const TABLE = 'witcher_jdr.activity';

    /**
     * Return all items.
     */
    public function getAll(): array {
        $activity = [];
        $request = $this->db->prepare("SELECT * FROM witcher_jdr.activity");
        $result = $request->execute();
        if($result) {
            $data = $request->fetchAll();
            foreach ($data as $activity) {
                $activity[] = new Activity($activity['id'], $activity['category'], $activity['type'],
                    $activity['name'], $activity['description'], $activity['link'], $activity['image']
                );
            }
        }
        return $activity;
    }

    /**
     * get Activities by a type
     * @param string $category
     * @return array
     */
    public function getActivitiesByCategory(string $category): array {
        $query = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE category = '$category' ORDER BY id DESC ");

        $array = [];

        if ($query && $data = $query->fetchAll()) {

            foreach ($data as $value) {
                $array[] = new Activity($value["id"], $value['category'], $value["type"], $value['name'],
                    $value['description'], $value['link'], $value['image']);
            }
        }

        return $array;
    }

    /**
     * Get Activity by category and type
     * @param $category
     * @param $type
     * @return array
     */
    public function getByCategoryAndType($category, $type) {
        $query = $this->db->query("
            SELECT * FROM " . self::TABLE . " WHERE category = '$category' AND type = '$type' ORDER BY id DESC");

        $array = [];

        if ($query && $data = $query->fetchAll()) {

            foreach ($data as $value) {
                $array[] = new Activity(
                    $value["id"], $value['category'], $value["type"], $value['name'], $value['description'],
                    $value['link'], $value['image']
                );
            }
        }

        return $array;
    }

    /**
     * Add an activity into the database.
     * @param Activity $activity
     * @return int
     */
    public function addActivity(Activity $activity): int
    {
        $request = $this->db->prepare("
            INSERT INTO witcher_jdr.activity (category, type, name, description, link, image) 
            VALUES (:category, :type, :name, :description, :link, :image)
            ");

        $request->bindValue(':category', $activity->getCategory());
        $request->bindValue(':type', $activity->getType());
        $request->bindValue(':name', $activity->getName());
        $request->bindValue(":description", $activity->getDescription());
        $request->bindValue(":link", $activity->getLink());
        $request->bindValue(":image", $activity->getImage());

        $request->execute();

        return $this->db->lastInsertId();
    }


    /**
     * update activity execept image name
     * @param $act
     * @param $id
     * @return null|int
     */
    public function updateActivity($act,$id)
    {
        $request = $this->db->prepare("
            UPDATE witcher_jdr.activity SET category = :category, type = :type, name = :name, description = :description, 
                                link = :link, image = :image
            WHERE id = :id"
        );
        // update : category / type / name / description / lien
        $request->bindValue(":category", $act->getCategory());
        $request->bindValue(":type", $act->getType());
        $request->bindValue(":name", $act->getName());
        $request->bindValue(":description", $act->getDescription());
        $request->bindValue(":link", $act->getLink());
        $request->bindValue(":image", $act->getImage());
        $request->bindValue(":id", $id);

        if($request->execute()) {
            return $id;
        }
        return null;
    }

    /**
     * Delete activity
     * @param $id
     */
    public function deleteActivity($id){
        $request = $this->db->prepare("DELETE FROM witcher_jdr.activity WHERE id = :id");
        $request->bindValue(":id", $id);
        $request->execute();
    }

    /**
     * Get article by id
     * @param $id
     * @return Activity|null
     */
    public function getById($id): ?Activity
    {
        $request = $this->db->prepare("SELECT * FROM witcher_jdr.activity WHERE id = :id");
        $request->bindValue(":id", $id);
        if($request->execute()){
            if($selected = $request->fetch()){
                return new Activity(
                    $selected["id"], $selected['category'], $selected["type"], $selected['name'],
                    $selected['description'], $selected['link'], $selected['image']
                );
            }
        }
        return null;
    }


}

