<?php


namespace App\Controller;

use App\Model\ContactManager;

class ContactController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('Contact/index.html.twig');
    }
}
