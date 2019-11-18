<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\ItemManager;
use App\Model\TeacherManager;

/**
 * Class AdminTeacherController
 *
 */
class AdminTeacherController extends AbstractController
{


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
            if (empty($errors)) {
                $teacherManager->update($data);
                header('Location: /AdminTeacher/edit/' . $data['id'] . '/?success=ok');
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
        $teacher = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teacherManager = new TeacherManager();
            $teacher = array_map('trim', $_POST);

            $errors = $this->validate($teacher);

            if (empty($errors)) {
                $teacherManager->insert($teacher);
                header('Location:/AdminTeacher/index');
            }
        }

        return $this->twig->render('Admin/Teacher/add.html.twig', [
            'teacher' => $teacher,
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
        if (empty($data['image'])) {
            $errors['image'] = 'Un nom d\'image doit être renseignée';
        }
        if (empty($data['pratique_id'])) {
            $errors['pratique_id'] = 'Le lieu de pratique doit être renseigné';
        }
        return $errors ?? [];
    }
}
