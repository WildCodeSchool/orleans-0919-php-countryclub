<?php


namespace App\Model;

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
                                `description` = :description,
                                `date` = :date
                                WHERE id=:id");
        $statement->bindValue('id', $news['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $news['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $news['description'], \PDO::PARAM_STR);
        $statement->bindValue('date', $news['date'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
