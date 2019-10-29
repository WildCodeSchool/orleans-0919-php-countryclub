<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\AssociationManager;

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
        $associationManager = new AssociationManager();
        $associations = $associationManager->selectAll();

        return $this->twig->render('Association/index.html.twig', ['associations' => $associations]);
    }


    /**
     * Display association informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $associationManager = new AssociationManager();
        $association = $associationManager->selectOneById($id);

        return $this->twig->render('Association/show.html.twig', ['association' => $association]);
    }


    /**
     * Display association edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $associationManager = new AssociationManager();
        $association = $associationManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $association['title'] = $_POST['title'];
            $associationManager->update($association);
        }

        return $this->twig->render('Association/edit.html.twig', ['association' => $association]);
    }


    /**
     * Display association creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $associationManager = new AssociationManager();
            $association = [
                'title' => $_POST['title'],
            ];
            $id = $associationManager->insert($association);
            header('Location:/association/show/' . $id);
        }

        return $this->twig->render('Association/add.html.twig');
    }


    /**
     * Handle association deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $associationManager = new AssociationManager();
        $associationManager->delete($id);
        header('Location:/association/index');
    }
}
