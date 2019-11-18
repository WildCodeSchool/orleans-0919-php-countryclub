<?php


namespace App\Model;


use DateTime;


class NewsManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'news';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    public function update(array $news):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("
                                UPDATE " . self::TABLE . "
                                SET `title` = :title, 
                                `description` = :description
                                WHERE id=:id");
        $statement->bindValue('id', $news['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $news['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $news['description'], \PDO::PARAM_STR);

        return $statement->execute();
    }
    public function add(array $news):bool
    {

        $date = new DateTime();

        $statement = $this->pdo->prepare(
            "INSERT INTO $this->table (`title`,`date`,`description`) 
                        VALUES ( :title,:date, :description ) "
        );
        $statement->bindValue('title', $news['title'], \PDO::PARAM_STR);
        $statement->bindValue('date', $date->format('Y-m-d'), \PDO::PARAM_STR);
        $statement->bindValue('description', $news['description'], \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (true);
        }
    }
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
