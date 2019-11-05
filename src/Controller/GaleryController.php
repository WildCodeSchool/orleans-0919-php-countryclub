<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\GaleryManager;

/**
 * Class GaleryController
 *
 */
class GaleryController extends AbstractController
{


    /**
     * Display galery listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $galeryManager = new GaleryManager();
        $galerys = $galeryManager->selectAll();

        return $this->twig->render('Galery/index.html.twig', ['galerys' => $galerys]);
    }


    /**
     * Display galery informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $galeryManager = new GaleryManager();
        $galery = $galeryManager->selectOneById($id);

        return $this->twig->render('Galery/show.html.twig', ['galery' => $galery]);
    }


    /**
     * Display galery edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $galeryManager = new GaleryManager();
        $galery = $galeryManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $galery['title'] = $_POST['title'];
            $galeryManager->update($galery);
        }

        return $this->twig->render('Galery/edit.html.twig', ['galery' => $galery]);
    }


    /**
     * Display galery creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $galeryManager = new GaleryManager();
            $galery = [
                'title' => $_POST['title'],
            ];
            $id = $galeryManager->insert($galery);
            header('Location:/galery/show/' . $id);
        }

        return $this->twig->render('Galery/add.html.twig');
    }


    /**
     * Handle galery deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $galeryManager = new GaleryManager();
        $galeryManager->delete($id);
        header('Location:/galery/index');
    }
}
