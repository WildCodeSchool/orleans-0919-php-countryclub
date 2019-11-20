<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\MemberManager;

/**
 * Class AdminMemberController
 *
 */
class AdminMemberController extends AbstractController
{

    const MAX_FILE_SIZE = 200000;
    const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/jpg'];

    /**
     * Display member listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $memberManager = new MemberManager();
        $members = $memberManager->selectAll();

        return $this->twig->render('Admin/Member/index.html.twig', ['members' => $members]);
    }

    /**
     * Display member edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $memberManager = new MemberManager();
        $member = $memberManager->selectOneById($id);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);

            if (!empty($_FILES['file']['name'])) {
                $path = $_FILES['file'];

                if ($path['error'] !== 0) {
                    $errors[] = 'Erreur de téléchargement';
                }
                // size du fichier
                if ($path['size'] > self::MAX_FILE_SIZE) {
                    $errors[] = 'La taille du fichier doit être < ' . (self::MAX_FILE_SIZE / 1000) . ' ko';
                }
                // type mime autorisés
                if (!in_array($path['type'], self::ALLOWED_MIMES)) {
                    $errors[] = 'Erreur d\'extension, les extensions autorisées 
                    sont : ' . implode(', ', self::ALLOWED_MIMES);
                }
            }

            if (empty($errors)) {
                if (!empty($path)) {
                    $fileName = uniqid() . '.' . pathinfo($path['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($path['tmp_name'], UPLOAD_PATH . $fileName);
                }
                $memberManager = new MemberManager();
                $member = $data;
                $member['picture'] = $fileName ?? '';
                $memberManager->update($member);
                header('Location: /AdminMember/edit/' . $member['id'] . '/?success=ok');
            }
        }

        return $this->twig->render('Admin/Member/edit.html.twig', [
            'member' => $member,
            'errors' => $errors ?? [],
            'success' => $_GET['success'] ?? null,
        ]);
    }

  
    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $memberManager = new MemberManager();
            $memberManager->delete($id);

            header('Location: /AdminMember/index');
        }
    }



    /**
     * Display member creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);
            if (!empty($_FILES['file']['name'])) {
                $path = $_FILES['file'];
                if ($path['error'] !== 0) {
                    $errors[] = 'Erreur de téléchargement';
                }
                // size du fichier
                if ($path['size'] > self::MAX_FILE_SIZE) {
                    $errors[] = 'La taille du fichier doit être < ' . (self::MAX_FILE_SIZE / 1000) . ' ko';
                }
                // type mime autorisés
                if (!in_array($path['type'], self::ALLOWED_MIMES)) {
                    $errors[] = 'Erreur d\'extension, les extensions autorisées 
                    sont : ' . implode(', ', self::ALLOWED_MIMES);
                }
            }
            if (empty($errors)) {
                // finalisation de l'upload en déplacant le fichier dans le dossier upload
                if (!empty($path)) {
                    $fileName = uniqid() . '.' . pathinfo($path['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($path['tmp_name'], UPLOAD_PATH . $fileName);
                }
                $memberManager = new MemberManager();
                $member = $data;
                $member['picture'] = $fileName ?? '';
                $memberManager->insert($member);
                header('Location:/AdminMember/index');
            }
        }
        return $this->twig->render('Admin/Member/add.html.twig', [
            'member' => $member ?? [],
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
        if (strlen($data['function']) > 155) {
            $errors['function'] = 'La fonction est trop longue';
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
        if (empty($data['function'])) {
            $errors['function'] = 'Une fonction doit être renseigné';
        }
        return $errors ?? [];
    }
}
