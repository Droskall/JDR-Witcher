<?php

namespace Model\Manager;

use Model\Entity\Sticker;
use Model\Manager\Traits\ManagerTrait;

class StickerManager
{
    use ManagerTrait;

    public const TABLE = 'sticker';

    /**
     * Create a new sticker
     * @param array $data
     * @param ActivityManager $activityManager
     * @param UserManager $userManager
     * @return Sticker
     */
    private function createSticker(array $data, ActivityManager $activityManager, UserManager $userManager): Sticker {
        return new Sticker(
            $data['id'],
            $data['type'],
            $activityManager->getById($data['activity_id']),
            $userManager->getById($data['user_id'])
        );
    }


    /**
     * add a new sticker in the db
     * @param string $type
     * @param int $userId
     * @param int $activityId
     * @return bool
     */
    public function addSticker(string $type, int $userId, int $activityId): bool
    {
        $stmt = $this->db->prepare("
                    INSERT INTO " . self::TABLE . " (type, user_id, activity_id) 
                    VALUES (:type, :user, :activity)
       ");

        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':user', $userId);
        $stmt->bindParam(':activity', $activityId);

        return $stmt->execute();
    }

    /**
     * Update a sticker's type
     * @param string $type
     * @param int $userId
     * @param int $activityId
     * @return bool
     */
    public function updateSticker(string $type, int $userId, int $activityId): bool
    {
        $stmt = $this->db->prepare("
                    UPDATE " . self::TABLE . " SET type = :type WHERE user_id = :user AND activity_id = :activity
        ");

        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':user', $userId);
        $stmt->bindParam(':activity', $activityId);

        return $stmt->execute();
    }

    /**
     * Update a sticker's type
     * @param int $userId
     * @param int $activityId
     * @return bool
     */
    public function deleteSticker(int $userId, int $activityId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM " . self::TABLE . " WHERE user_id = :user AND activity_id = :activity");

        $stmt->bindParam(':user', $userId);
        $stmt->bindParam(':activity', $activityId);

        return $stmt->execute();
    }

    /**
     * get stickers by a type and an id following the given $field
     * @param string $field
     * @param int $id
     * @param string|null $type
     * @return array
     */
    public function getStickersByAnId(string $field, int $id, string $type): array {
        $query = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE $field = $id AND type = '$type'");

        $array = [];

        if ($query && $data = $query->fetchAll()) {
            $activityManager = new ActivityManager();
            $userManager = new UserManager();

            foreach ($data as $value) {
               $array[] = self::createSticker($value, $activityManager, $userManager);
            }

        }
        return $array;
    }

    /**
     * Count every interaction on an activity
     * @param int $id
     * @return mixed|null
     */
    public function countActivityInteractions(int $id) {
        $query = $this->db->query("SELECT count(*) FROM " . self::TABLE . " WHERE activity_id = $id");

        if ($query) {
            return $query->fetch()['count(*)'];
        }

        return null;
    }

    /**
     * Count every $type interaction for an id in $field,
     * @param string $field
     * @param int $id
     * @param string $type
     * @return mixed|null
     */
    public function countInteractionsByType(string $field, int $id, string $type) {
        $query = $this->db->query("SELECT count(*) FROM " . self::TABLE . " WHERE $field = $id AND type = '$type'");

        if ($query) {
            return $query->fetch()['count(*)'];
        }

        return null;
    }

    /**
     * Check if a user has already reacted to an activity (if yes return the type of reaction else null)
     * @param int $activityId
     * @param int $userId
     * @return mixed|null
     */
    public function hasAlreadyReacted(int $activityId, int $userId) {
        $query = $this->db->query(
            "SELECT type FROM " . self::TABLE .
                " WHERE activity_id = $activityId AND user_id = $userId"
        );

        if ($query) {
            return $query->fetch();
        }

        return null;
    }

}