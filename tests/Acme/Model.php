<?php

namespace JWorksUK\Acme;

use DateTime;

/**
 * Class Model
 * @package JWorksUK\Acme
 */
class Model
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $listId;
    /**
     * @var DateTime
     */
    private $updatedAt;
    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * Model constructor.
     * @param string $id
     * @param string $name
     * @param string $listId
     * @param DateTime $updatedAt
     * @param DateTime $createdAt
     */
    public function __construct(
        string $id,
        string $name,
        string $listId,
        DateTime $updatedAt,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->listId = $listId;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getListId(): string
    {
        return $this->listId;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
