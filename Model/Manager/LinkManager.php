<?php

namespace Model\Manager;

use Model\Entity\link;
use Model\Manager\Traits\ManagerTrait;

class LinkManager
{
    use ManagerTrait;

    public const TABLE = 'link';

    /**
     * Create a new sticker
     * @param array $data
     * @return Link
     */
    private function createLink(array $data): Link {
        return new Link(
            $data['id'],
            $data['url'],
            $data['type'],
            $data['title']
        );
    }

    /**
     * Add a new link
     * @param string $url
     * @param string $type
     * @param string $title
     * @return bool
     */
    public function addLink(string $url, string $type, string $title): bool {
        $stmt = $this->db->prepare("
                    INSERT INTO " . self::TABLE . " (url, type, title) 
                    VALUES (:url, :type, :title)
       ");

        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':title', $title);

        return $stmt->execute();
    }

    /**
     * Update a link
     * @param int $id
     * @param string $url
     * @param string $type
     * @param string $title
     * @return bool
     */
    public function updateLink(int $id, string $url, string $type, string $title): bool {
        $stmt = $this->db->prepare("
                    UPDATE " . self::TABLE . " SET url = :url, type = :type, title = :title WHERE id = :id
       ");

        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Delete a link
     * @param int $id
     * @return bool
     */
    public function deleteLink(int $id): bool {
        $stmt = $this->db->prepare(" DELETE FROM " . self::TABLE . " WHERE id = :id");

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Get links by type
     * @param string $type
     * @return array
     */
    public function getLinkByType(string $type): array {
        $query = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE type = '$type' ORDER BY title");

        $array = [];

        if ($query && $data = $query->fetchAll()) {
            foreach ($data as $value) {
                $array[] = self::createLink($value);
            }
        }
        return $array;
    }

    public function getLinkById(int $id)
    {
        $query = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE id = $id");
        if($query){
            return self::createLink($query->fetch());
        }
        return null;
    }

}