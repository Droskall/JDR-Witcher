<?php

namespace Model\Entity;

class Sticker
{
    private ?int $id;
    private ?string $type;
    private ?Activity $activity;
    private ?User $user;

    /**
     * Comment constructor.
     * @param int|null $id
     * @param string|null $type
     * @param Activity|null $activity
     * @param User|null $user
     */
    public function __construct(int $id = null, string $type = null, Activity $activity = null, User $user = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->activity = $activity;
        $this->user = $user;
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
     * @return Sticker
     */
    public function setId(?int $id): Sticker
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Sticker
     */
    public function setType(?string $type): Sticker
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return Sticker
     */
    public function setActivity(?Activity $activity): Sticker
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Sticker
     */
    public function setUser(?User $user): Sticker
    {
        $this->user = $user;
        return $this;
    }

}