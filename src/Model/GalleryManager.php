<?php


namespace App\Model;

class GalleryManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'photo';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
