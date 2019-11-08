<?php


namespace App\Controller;


class AdhererController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('Adherer/index.html.twig');
    }
}