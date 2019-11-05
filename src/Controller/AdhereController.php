<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\AdhereManager;

/**
 * Class AdhereController
 *
 */
class AdhereController extends AbstractController
{


    /**
     * Display adhere listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $adhereManager = new AdhereManager();
        $adheres = $adhereManager->selectAll();

        return $this->twig->render('Adhere/index.html.twig', ['adheres' => $adheres]);
    }


    /**
     * Display adhere informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $adhereManager = new AdhereManager();
        $adhere = $adhereManager->selectOneById($id);

        return $this->twig->render('Adhere/show.html.twig', ['adhere' => $adhere]);
    }


    /**
     * Display adhere edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $adhereManager = new AdhereManager();
        $adhere = $adhereManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adhere['title'] = $_POST['title'];
            $adhereManager->update($adhere);
        }

        return $this->twig->render('Adhere/edit.html.twig', ['adhere' => $adhere]);
    }


    /**
     * Display adhere creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adhereManager = new AdhereManager();
            $adhere = [
                'title' => $_POST['title'],
            ];
            $id = $adhereManager->insert($adhere);
            header('Location:/adhere/show/' . $id);
        }

        return $this->twig->render('Adhere/add.html.twig');
    }


    /**
     * Handle adhere deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $adhereManager = new AdhereManager();
        $adhereManager->delete($id);
        header('Location:/adhere/index');
    }
}
