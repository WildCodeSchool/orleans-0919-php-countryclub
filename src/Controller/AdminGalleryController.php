<?php

namespace App\Controller;

use App\Model\GalleryManager;

class AdminGalleryController extends AbstractController
{
    public function index()
    {
        $galleryManager = new GalleryManager();
        $photos = $galleryManager->selectAll();

        return $this->twig->render('Admin/Picture/index.html.twig', ['photos' => $photos]);
    }
}
