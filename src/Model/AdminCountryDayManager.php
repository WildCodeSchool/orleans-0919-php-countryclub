<?php


namespace App\Model;

class AdminCountryDayManager extends AbstractManager
{
    const TABLE = 'event';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $data)
    {

        // prepared request
        $statement = $this->pdo->prepare("
                    INSERT INTO $this->table(subtitle,description,image,video,date )
                     VALUES (:subtitle, :description,:image,:media,:date) ");
        $statement->bindValue('subtitle', $data['subtitle'], \PDO::PARAM_STR);
        $statement->bindValue('description', $data['description'], \PDO::PARAM_STR);
        $statement->bindValue('image', $_FILES['file']['name'], \PDO::PARAM_STR);
        $statement->bindValue('media', $_FILES['media']['name'], \PDO::PARAM_STR);
        $statement->bindValue('date', $data['date'], \PDO::PARAM_STR);
        $statement->execute();
    }
}
