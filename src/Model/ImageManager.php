<?php

namespace App\Model;

use PDO;

class ImageManager extends AbstractManager
{
    public const TABLE = 'image';

    /**
     * Insert new image in database
     */
    public function insert(array $image): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (`title`, `description`) VALUES (:title, :description)");
        $statement->bindValue('title', $image['title'], PDO::PARAM_STR);
        $statement->bindValue('description', $image['description'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update image in database
     */
    public function update(array $image): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
        " SET `title` = :title, `description` = :description WHERE id=:id");
        $statement->bindValue('id', $image['id'], PDO::PARAM_INT);
        $statement->bindValue('title', $image['title'], PDO::PARAM_STR);
        $statement->bindValue('description', $image['description'], PDO::PARAM_STR);

        return $statement->execute();
    }
}
