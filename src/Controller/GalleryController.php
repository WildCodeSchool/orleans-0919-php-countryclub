<?php


namespace App\Controller;

use App\Model\GalleryManager;

class GalleryController extends AbstractController
{
    public function index()
    {
        $galleryManager = new GalleryManager();
        $photos = $galleryManager->selectAll();
        return $this->twig->render('Gallery/index.html.twig', ['photos' => $photos]);
    }
}

