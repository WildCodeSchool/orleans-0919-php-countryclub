<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\TeacherManager;

/**
 * Class AdminTeacherController
 *
 */
class AdminTeacherController extends AbstractController
{

    const MAX_FILE_SIZE = 200000;
    const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/jpg'];

    /**
     * Display teacher listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $teacherManager = new TeacherManager();
        $teachers = $teacherManager->selectAll();

        return $this->twig->render('Admin/Teacher/index.html.twig', ['teachers' => $teachers]);
    }

    /**
     * Display teacher edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $teacherManager = new TeacherManager();
        $teacher = $teacherManager->selectOneById($id);


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
                $teacher = [
                    'id' => $_POST['id'],
                    'firstname' => $_POST['firstname'],
                    'lastname'  => $_POST['lastname'],
                    'description' => $_POST['description'],
                    'image'      => $fileName ?? '',
                ];
                $teacherManager->update($teacher);
                header('Location: /AdminTeacher/edit/' . $teacher['id'] . '/?success=ok');
            }
        }

        return $this->twig->render('Admin/Teacher/edit.html.twig', [
            'teacher' => $teacher,
            'errors' => $errors ?? [],
            'success' => $_GET['success'] ?? null,
        ]);
    }


    /**
     * Display teacher creation page
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

                $teacherManager = new TeacherManager();
                $teacher = [
                    'firstname' => $_POST['firstname'],
                    'lastname'  => $_POST['lastname'],
                    'description' => $_POST['description'],
                    'image'      => $fileName ?? '',
                ];
                $teacherManager->insert($teacher);
                header('Location:/AdminTeacher/index');
            }
        }

        return $this->twig->render('Admin/Teacher/add.html.twig', [
            'teacher' => $teacher ?? [],
            'errors' => $errors ?? [],
            'success' => $_GET['success'] ?? null,
        ]);
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teacherManager = new TeacherManager();
            $teacher = $teacherManager->selectOneById($id);
            if ($teacher) {
                unlink(UPLOAD_PATH . $teacher['image']);
                $teacherManager->delete($id);
            }
            header('Location: /AdminTeacher/index');
        }
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
        if (empty($data['description'])) {
            $errors['description'] = 'Une description doit être renseignée';
        }
        return $errors ?? [];
    }
}
