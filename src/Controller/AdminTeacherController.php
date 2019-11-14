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
}
