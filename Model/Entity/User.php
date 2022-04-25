<?php

namespace Model\Entity;

class User {

    private ?int $id;
    private ?string $email;
    private ?string $username;
    private ?string $password;
    private ?string $avatar;
    private ?string $role;


    /**
     * @param string|null $email
     * @param string|null $username
     * @param string|null $password
     * @param string|null $avatar
     * @param string|null $role
     * @param int|null $id
     */
    public function __construct(string $email = null, string $username = null, string $password = null,
                                string $avatar = null ,string $role = null , int $id = null) {

        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->avatar = $avatar;
        $this->role = $role;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return User
     */
    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     * @return User
     */
    public function setAvatar(?string $avatar): User
    {
        $this->avatar = $avatar;
        return $this;
    }


    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return User
     */
    public function setRole(string $role): User
    {
        $this->role = $role;
        return $this;
    }
}
