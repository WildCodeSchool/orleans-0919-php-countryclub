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

        return $this->twig->render('Admin/index.html.twig');
    }
    public function add()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminManager = new AdminManager();
            $data = array_map('trim', $_POST);
            if (empty($data['subtitle'])) {
                $errors['subtitle'] = "The title is required ";
            }
            if (empty($data['description'])) {
                $errors['description'] = "Description of Country Day is required ";
            }
            if (empty($_FILES['file']['name'][0])) {
                $errors['file']['name'] = "Country Days's image is required ";
            }
            if (empty($errors)) {
                $addCountry = $adminManager->insert($data);
                header('Location: Admin/index');
            }
        }
        return $this->twig->render('Admin/addCountry.html.twig');
    }
}
