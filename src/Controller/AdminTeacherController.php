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
            $teacher['firstname'] = $_POST['firstname'];
            $teacherManager->update($teacher);
        }

        return $this->twig->render('Admin/Teacher/edit.html.twig', ['teacher' => $teacher]);
    }
}
