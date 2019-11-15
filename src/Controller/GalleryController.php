<?php


namespace App\Controller;

use App\Model\GalleryManager;

class GalleryController extends AbstractController
{
    public function index()
    {
        $GalleryManager = new GalleryManager();
        $photos = $GalleryManager->selectAll();
        return $this->twig->render('Gallery/index.html.twig', ['photos' => $photos]);
    }
}