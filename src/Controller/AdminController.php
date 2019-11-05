<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\AdminManager;

/**
 * Class AdminController
 *
 */
class AdminController extends AbstractController
{


    /**
     * Display admin listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $adminManager = new AdminManager();
        $admins = $adminManager->selectAll();

        return $this->twig->render('Admin/index.html.twig', ['admins' => $admins]);
    }


    /**
     * Display admin informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $adminManager = new AdminManager();
        $admin = $adminManager->selectOneById($id);

        return $this->twig->render('Admin/show.html.twig', ['admin' => $admin]);
    }


    /**
     * Display admin edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $adminManager = new AdminManager();
        $admin = $adminManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin['title'] = $_POST['title'];
            $adminManager->update($admin);
        }

        return $this->twig->render('Admin/edit.html.twig', ['admin' => $admin]);
    }


    /**
     * Display admin creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminManager = new AdminManager();
            $admin = [
                'title' => $_POST['title'],
            ];
            $id = $adminManager->insert($admin);
            header('Location:/admin/show/' . $id);
        }

        return $this->twig->render('Admin/add.html.twig');
    }


    /**
     * Handle admin deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $adminManager = new AdminManager();
        $adminManager->delete($id);
        header('Location:/admin/index');
    }
}
