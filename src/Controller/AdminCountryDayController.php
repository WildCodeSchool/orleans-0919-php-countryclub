<?php
namespace App\Controller;

use App\Model\AdminCountryDayManager;

class AdminCountryDayController extends AbstractController
{
    public function add()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminCountryDay = new AdminCountryDayManager();
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);
            if (empty($errors)) {
                $adminCountryDay->insert($data);
                header('Location: Admin/index/');
            }
        }
        return $this->twig->render('CountryDay/add.html.twig', [
            'errors' => $errors,
            'data' => $data ?? null,
        ]);
    }
    private function validate(array $data): array
    {
        if (empty($data['subtitle'])) {
            $errors['subtitle'] = "The title is required ";
        }
        if (empty($data['description'])) {
            $errors['description'] = "Description of Country Day is required ";
        }
        if (empty($data['file'])) {
            $errors['image'] = "Country Days's image is required ";
        }
        if (empty($data['media'])) {
            $errors['video'] = "Country Days's image is required ";
        }
        if (empty($data['date'])) {
            $errors['date'] = "Date must be current Date";
        }
        return $errors ?? [];
    }
}
