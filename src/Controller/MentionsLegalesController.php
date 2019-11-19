<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\MentionsLegalesManager;

/**
 * Class MentionsLegalesController
 *
 */
class MentionsLegalesController extends AbstractController
{


    /**
     * Display mentionsLegales listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('MentionsLegales/index.html.twig');
    }
}
