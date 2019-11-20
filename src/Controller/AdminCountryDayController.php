<?php
namespace App\Controller;

use App\Model\AdminCountryDayManager;

class AdminCountryDayController extends AbstractController
{
    public function index()
    {
        $adminCountryDay = new AdminCountryDayManager();
        $events = $adminCountryDay->selectAll();
        return $this->twig->render('CountryDay/index.html.twig', ['events' => $events]);
    }
    public function add()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminCountryDay = new AdminCountryDayManager();
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);
            if (empty($errors)) {
                if ($_FILES['file']['size'] <= $data['MAX_FILE_SIZE']) {
                    $odlDest = $_FILES['file']['tmp_name'];
                    $newDest = 'assets/upload/'.$_FILES['file']['name'];
                    move_uploaded_file($odlDest, $newDest);
                }
                $adminCountryDay->insert($data);
                header('Location: /AdminCountryDay/index/');
            }
        }
        return $this->twig->render('/CountryDay/add.html.twig', [
            'errors' => $errors,
            'data' => $data ?? null,
        ]);
    }
    private function validate(array $data): array
    {
        if (empty($data['subtitle'])) {
            $errors['subtitle'] = "Le titre de l'évènement doit être  indiqué ";
        }
        if (empty($data['description'])) {
            $errors['description'] = "La description doit être renseignée ";
        }
        if (empty($_FILES['file']['name'])) {
            $errors['file'] = "L'affiche du Country Day  doit  être renseignée";
        }
        if (empty($data['media'])) {
            $errors['media'] = "La vidéo  doit être indiquée ";
        }
        if (empty($data['date'])) {
            $errors['date'] = "La date  doit être indiquée";
        }
        return $errors ?? [];
    }


    public function edit(int $id): string
    {
        $adminCountryDay = new AdminCountryDayManager();
        $event = $adminCountryDay->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);
            if (empty($errors)) {
                if ($_FILES['file']['size'] <= $data['MAX_FILE_SIZE']) {
                    $odlDest = $_FILES['file']['tmp_name'];
                    $newDest = 'assets/upload/'.$_FILES['file']['name'];
                    move_uploaded_file($odlDest, $newDest);
                }
                $adminCountryDay->update($data);
                header('Location: /AdminCountryDay/index');
            }
        }
        return $this->twig->render('/CountryDay/edit.html.twig', [
            'data' => $event,
            'errors' => $errors ?? [],
            'success' => $_GET['success'] ?? null,
        ]);
    }
}
