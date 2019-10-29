<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class AssociationManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'association';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $association
     * @return int
     */
    public function insert(array $association): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`title`) VALUES (:title)");
        $statement->bindValue('title', $association['title'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param array $association
     * @return bool
     */
    public function update(array $association):bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $association['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $association['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
