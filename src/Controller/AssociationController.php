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
use App\Model\TeacherManager;

/**
 * Class AssociationController
 *
 */
class AssociationController extends AbstractController
{


    /**
     * Display association listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $teacherManager = new TeacherManager();
        $teachers = $teacherManager->selectAllTables();

        $memberManager = new MemberManager();
        $members = $memberManager->selectAll();


        return $this->twig->render('/Association/index.html.twig', [
            'teachers' => $teachers,
            'members' => $members,
        ]);
    }
}
