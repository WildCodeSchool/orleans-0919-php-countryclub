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
class CountryManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'countryDay';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get last row from database.
     *
     * @return array
     */
    public function selectLast(): array
    {
        return $this->pdo->query("SELECT * FROM  $this->table ORDER BY  date DESC LIMIT 1")->fetch();
    }
}
