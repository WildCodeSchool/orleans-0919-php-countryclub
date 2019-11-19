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
class MemberManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'member';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $member
     * @return bool
     */
    public function update(array $member): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("
                                UPDATE " . self::TABLE . "
                                SET `firstname` = :firstname, `lastname` = :lastname, 
                                `function` = :function, `picture` = :picture
                                WHERE id=:id");
        $statement->bindValue('id', $member['id'], \PDO::PARAM_INT);
        $statement->bindValue('firstname', $member['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $member['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('function', $member['function'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $member['picture'], \PDO::PARAM_STR);

        return $statement->execute();
    }


    public function delete(int $id)
    {
        $statement = $this->pdo->prepare("DELETE FROM ". self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

    /**
     * @param array $member
     * @return int
     */
    public function insert(array $member): int
    {
        $statement = $this->pdo->prepare("
            INSERT INTO " . self::TABLE . " (firstname, lastname, function, picture)
            VALUES (:firstname, :lastname, :function, :picture)");
        $statement->bindValue('firstname', $member['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $member['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('function', $member['function'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $member['picture'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
