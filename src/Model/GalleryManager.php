<?php


namespace App\Model;

class GalleryManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'picture';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
    public function update(array $gallery):bool
    {
        $statement = $this->pdo->prepare("
                                UPDATE " . self::TABLE . "
                                SET `photo` = :photo, `title` = :title,
                                WHERE id=:id");
        $statement->bindValue('id', $gallery['id'], \PDO::PARAM_INT);
        $statement->bindValue('path', $gallery['photo'], \PDO::PARAM_STR);
        $statement->bindValue('title', $gallery['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
    public function insert(array $gallery)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "
                                                    (path, title) VALUES (:path , :title)");
        $statement->bindValue('path', $gallery['file']['name'], \PDO::PARAM_STR);
        $statement->bindValue('title', $gallery['title'], \PDO::PARAM_STR);
        $statement->execute();
    }

    public function delete(int $id)
    {
        $statement = $this->pdo->prepare("DELETE FROM ". self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
