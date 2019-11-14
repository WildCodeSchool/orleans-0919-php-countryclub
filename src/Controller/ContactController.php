<?php


namespace App\Controller;

use App\Model\ContactManager;

class ContactController extends AbstractController
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);

            if (empty($errors)) {
                header('Location: /Contact/index/?success=ok');
            }
        }
        return $this->twig->render('Contact/index.html.twig', [
            'errors' => $errors ?? [],
            'success' => $_GET['success'] ?? null,
        ]);
    }

    private function validate($data)
    {
        $emptyErrors = $this->validateEmpty($data);
        $errors = [];

        if (strlen($data['lastname']) > 155) {
            $errors['lastname'] = 'Le nom est trop long';
        }

        if (strlen($data['firstname']) > 155) {
            $errors['firstname'] = 'Le prénom est trop long';
        }

        if (strlen($data['mail']) > 50) {
            $errors['mail'] = 'Le mail est trop long';
        }

        if (!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] = "Votre mail est invalide";
        }

        if (strlen($data['subject']) > 155) {
            $errors['subject'] = 'Votre sujet est trop long';
        }

        if (strlen($data['msg']) > 255) {
            $errors['msg'] = 'Votre message est trop long';
        }

        return array_merge($emptyErrors, $errors);
    }

    private function validateEmpty(array $data)
    {
        if (empty($data['lastname'])) {
            $errors['lastname'] = 'Le nom doit être indiqué';
        }

        if (empty($data['firstname'])) {
            $errors['firstname'] = 'Le prénom doit être indiqué';
        }

        if (empty($data['mail'])) {
            $errors['mail'] = 'Le mail doit être précisé';
        }

        if (empty($data['subject'])) {
            $errors['subject'] = 'Votre sujet doit être mentionné';
        }

        if (empty($data['msg'])) {
            $errors['msg'] = 'Votre message doit être mentionné';
        }

        return $errors ?? [];
    }
}
