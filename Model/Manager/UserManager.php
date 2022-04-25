<?php

namespace Model\Manager;

use Model\Entity\User;
use Model\Manager\Traits\ManagerTrait;

class UserManager
{

    use ManagerTrait;

    /**
     * Returns a user via their id.
     * @param int $id
     * @return User
     */
    public function getById(int $id): User
    {
        $user = new User();
        $request = $this->db->prepare("SELECT id, username, role FROM user WHERE id = $id");
        $request->bindValue('id', $id);
        $result = $request->execute();
        if ($result) {
            $user_data = $request->fetch();
            if ($user_data) {
                $user->setId($user_data['id']);
                $user->setUsername($user_data['username']);
                $user->setRole($user_data['role']);
            }
        }
        return $user;
    }

    /**
     * Add a user in bdd
     * @param $email
     * @param $name
     * @param $pass
     * @param $token
     * @return User
     */
    public function insertUser($email, $name, $pass, $token): User
    {

        $request = $this->db->prepare("INSERT INTO user (email, username, password, role, token) VALUES ( :mail ,:name, :pass , 'none', :token)");
        $request->bindValue(":mail", $email);
        $request->bindValue(":name", $name);
        $request->bindValue(":pass", $pass);
        $request->bindValue(':token', $token);
        $request->execute();

        $user = new User();
        return $user
            ->setId($this->db->lastInsertId())
            ->setEmail($email)
            ->setUsername($name)
            ->setPassword($pass)
            ->setRole('none');
    }

    /**
     * Function that selects a user if he exists in database
     * @param $email
     * @return User
     */
    public function getUser($email): ?User
    {
        $request = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $request->bindValue(":email", $email);

        if ($request->execute() && $select = $request->fetch()) {
            $user = new User();
            return $user
                ->setId($select["id"])
                ->setEmail($select["email"])
                ->setUsername($select["username"])
                ->setPassword($select['password'])
                ->setAvatar($select["avatar"])
                ->setRole($select["role"]);
        }
        return null;
    }

    /**
     * Check if a user exists.
     * @param int $id
     * @return bool
     */
    public function userExists(int $id): bool
    {
        $result = $this->db->query("SELECT count(*) as cnt FROM user WHERE id = $id");
        return $result ? $result->fetch()['cnt'] : 0;
    }

    /**
     * Delete a user from user db.
     * @param $id
     * @return bool
     */
    public function deleteUser($id): bool
    {
        $request = $this->db->prepare("DELETE FROM user WHERE id = :id");

        $request->bindValue(":id", $id);

        return $request->execute();
    }

    /**
     * Modify a user role
     * @param $role
     * @param $id
     */
    public function modifUserRole($role, $id)
    {

        $request = $this->db->prepare("UPDATE user SET role = :role WHERE id = :id");

        $request->bindValue(":role", $role);
        $request->bindValue(":id", $id);

        $request->execute();

    }

    /**
     * Return all available users.
     * @return array
     */
    public function getAll(): array
    {
        $users = [];
        $result = $this->db->query("SELECT * FROM user");

        if ($result) {
            foreach ($result->fetchAll() as $data) {
                $users[] = (new UserManager)->getUser($data['email']);
            }
        }
        return $users;
    }

    /**
     * @param $avatar
     * @param $id
     * @return false|\PDOStatement
     */
    public function updateAvatar($avatar, $id)
    {
        return $this->db->query("UPDATE user SET avatar = '$avatar' WHERE id = $id");
    }

    /**
     * Update the mail and the username
     * @param $email
     * @param $username
     * @param $id
     * @return bool
     */
    public function updateMailName($email, $username, $id): bool
    {
        $stmt = $this->db->prepare("UPDATE user SET email = :email, username = :username WHERE id = :id");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * update the password
     * @param $password
     * @param $id
     * @return bool
     */
    public function updatePassword($password, $id): bool
    {
        $stmt = $this->db->prepare("UPDATE user SET password = :password WHERE id = :id");

        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * update the password by email
     * @param $password
     * @param $mail
     * @return bool
     */
    public function updatePasswordByMail($password, $mail): bool
    {
        $stmt = $this->db->prepare("UPDATE user SET password = :password WHERE email = :email");

        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $mail);

        return $stmt->execute();
    }

    /**
     * count the admin number
     * @return mixed
     */
    public function isLastAdmin() {
        $query = $this->db->query("SELECT count(id) FROM user WHERE role = 'admin'");
        return $query->fetch()['count(id)'];
    }
}