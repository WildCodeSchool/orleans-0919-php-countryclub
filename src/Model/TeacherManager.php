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
class TeacherManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'teacher';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get all row from database.
     *
     * @return array
     */
    public function selectAllTables(): array
    {
        return $this->pdo->query('
                SELECT * FROM ' . self::TABLE .
            ' JOIN practice p ON teacher.pratique_id = p.id')->fetchAll();
    }


    /**
     * @param array $teacher
     * @return bool
     */
    public function update(array $teacher):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("
                                UPDATE " . self::TABLE . "
                                SET `firstname` = :firstname, `lastname` = :lastname, 
                                `description` = :description, `image` = :image
                                WHERE id=:id");
        $statement->bindValue('id', $teacher['id'], \PDO::PARAM_INT);
        $statement->bindValue('firstname', $teacher['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $teacher['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('description', $teacher['description'], \PDO::PARAM_STR);
        $statement->bindValue('image', $teacher['image'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    /**
     * @param array $teacher
     * @return int
     */
    public function insert(array $teacher): int
    {
        // prepared request
        $statement = $this->pdo->prepare("
                INSERT INTO " . self::TABLE . " (firstname, lastname, description, image, pratique_id) 
                VALUES (:firstname, :lastname, :description, :image, :pratique_id)");
        $statement->bindValue('firstname', $teacher['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $teacher['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('description', $teacher['description'], \PDO::PARAM_STR);
        $statement->bindValue('image', $teacher['image'], \PDO::PARAM_STR);
        $statement->bindValue('pratique_id', $teacher['pratique_id'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }



}
