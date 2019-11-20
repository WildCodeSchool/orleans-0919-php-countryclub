<?php


namespace App\Controller;

class JoinController extends AbstractController
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);
            if (empty($errors)) {
                header('Location: /Join/index/?success=ok');
            }
        }

        return $this->twig->render('Join/index.html.twig', [
                'errors' => $errors ?? [],
                'success' => $_GET['success'] ?? null,
            ]);
    }

    private function validate($data)
    {
        $errors = [];

        //start validation
        if (empty($data['firstname'])) {
            $errors['firstname'] = "Vous devez renseignez un prénom.";
        }
        if (empty($data['lastname'])) {
            $errors['lastname'] = "Vous devez renseignez un nom.";
        }
        if (empty($data['email'])) {
            $errors['email'] = "Vous devez renseignez un mail";
        } elseif (!filter_var($data ['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Votre mail est invalide";
        }
        if (empty($data['town'])) {
            $errors['town'] = "Vous devez renseignez une ville";
        }
        if (empty($data['tel'])) {
            $errors['tel'] = "Vous devez renseignez un numéro de téléphone";
        }
        if (empty($data['cp'])) {
            $errors['cp'] = "Vous devez renseignez votre code postal";
        }

        return $errors;
    }
}
