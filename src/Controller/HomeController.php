<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;


use App\Model\CountryManager;

use App\Model\NewsManager;


class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function index()
    {

        $countryManager = new CountryManager();
        $countryDays = $countryManager->selectLast();
        return $this->twig->render('Home/index.html.twig', ['countryDay' => $countryDays]);


        $newsManager = new NewsManager();
        $news = $newsManager->selectAll();
        return $this->twig->render('Home/index.html.twig', ['news' =>$news]);

    }
}
