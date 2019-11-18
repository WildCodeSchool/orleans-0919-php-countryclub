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
}