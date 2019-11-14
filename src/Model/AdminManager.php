<?php


namespace App\Model;

class AdminManager extends AbstractManager
{
    const TABLE = 'countryDay';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $countryDay)
    {

        // prepared request
        $statement = $this->pdo->prepare("
                    INSERT INTO $this->table(subtitle,description,image, video,date )
                     VALUES (:subtitle, :description,:image, ;video, :date ) ");
        $statement->bindValue('subtitle', $countryDay['subtitle'], \PDO::PARAM_STR);
        $statement->bindValue('description', $countryDay['description'], \PDO::PARAM_STR);
        $statement->bindValue('image', $countryDay['image'], \PDO::PARAM_STR);
        $statement->bindValue('video', $countryDay['video'], \PDO::PARAM_NULL);
        $statement->bindValue('image', $countryDay['image'], \PDO::PARAM_INT);
        $statement->execute();
    }
}
