<?php

namespace App\Controller;

use App\Model\GalleryManager;

class AdminGalleryController extends AbstractController
{
    const MAX_SIZE = 200000;

    public function index()
    {
        $galleryManager = new GalleryManager();
        $photos = $galleryManager->selectAll();

        return $this->twig->render('Admin/Gallery/index.html.twig', ['photos' => $photos]);
    }

    public function add()
    {
        $data = [];
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $galleryManager = new GalleryManager();
            $data = array_map('trim', $_POST);
            $data['file'] = $_FILES['file'];
            $errors = $this->validate($data);

            if (empty($errors)) {
                    $odlDest = $data['file']['tmp_name'];
                    $newDest = 'assets/upload/gallery/' . $data['file']['name'];
                    move_uploaded_file($odlDest, $newDest);

                $galleryManager->insert($data);
                header('Location: /AdminGallery/index');
            }
        }

        return $this->twig->render('Admin/Gallery/add.html.twig', [
            'errors' => $errors ?? [],
            'data' => $data ?? null,
        ]);
    }

    private function validate($data): array
    {
        $emptyErrors = $this->noValidate($data);
        $errors = [];

        if ($data['file']['size'] >  self::MAX_SIZE) {
            $errors['file'] = 'Le fichier est trop gros, il ne doit pas excéder ' . self::MAX_SIZE;
        }
        if (strlen($data['title']) > 155) {
            $errors['title'] = 'Le titre est trop long';
        }
        return array_merge($emptyErrors, $errors);
    }

    private function noValidate(array $data)
    {
        if (empty($data['title'])) {
            $errors['title'] = 'Le titre doit être renseigné';
        }
        return $errors ?? [];
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $galleryManager = new GalleryManager();
            $galleryManager->selectOneById($id);
            $galleryManager->delete($id);

            header('Location: /AdminGallery/index');
        }
    }
}
