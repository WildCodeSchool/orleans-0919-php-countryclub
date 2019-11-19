<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\ItemManager;
use App\Model\NewsManager;

/**
 * Class AdminNewsController
 *
 */
class AdminNewsController extends AbstractController
{


    /**
     * Display news listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $newsManager = new NewsManager();
        $news = $newsManager->selectAll();

        return $this->twig->render('Admin/News/index.html.twig', ['news' => $news]);
    }
    public function edit(int $id): string
    {
        $newsManager = new NewsManager();
        $news = $newsManager->selectOneById($id);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);
            if (empty($errors)) {
                $newsManager->update($data);
                header('Location: /AdminNews/edit/' . $data['id'] . '/?success=ok');
            }
        }
        return $this->twig->render('Admin/News/edit.html.twig', [
            'news' => $news,
            'errors' => $errors ?? [],
            'success' => $_GET['success'] ?? null,
        ]);
    }
    private function validate($data)
    {
        $emptyErrors = $this->validateEmpty($data);
        $errors = [];
        if (strlen($data['title']) > 155) {
            $errors['titre'] = 'Le titre est trop long';
        }
        return array_merge($emptyErrors, $errors);
    }

    private function validateEmpty(array $data)
    {
        if (empty($data['title'])) {
            $errors['titre'] = 'Le titre doit être indiqué';
        }
        if (empty($data['description'])) {
            $errors['description'] = 'Veuillez saisir un texte';
        }
        return $errors ?? [];
    }
    public function add()
    {
        $newsManager = new NewsManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);

            if (empty($errors)) {
                $newsManager->add($data);
                header('Location: /AdminNews/index/?success=ok');
            }
        }
        return $this->twig->render('Admin/News/add.html.twig', [
            'errors' => $errors ?? [],
            'success' => $_GET['success'] ?? null,
        ]);
    }
    public function delete(int $id)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newsManager = new NewsManager();
            $newsManager->delete($id);
            header('Location:/AdminNews/index');
        }
    }
}
