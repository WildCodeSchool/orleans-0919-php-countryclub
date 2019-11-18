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

    /**
     * Display member edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $memberManager = new MemberManager();
        $member = $memberManager->selectOneById($id);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $errors = $this->validate($data);
            if (empty($errors)) {
                $memberManager->update($data);
                header('Location: /AdminMember/edit/' . $data['id'] . '/?success=ok');
            }
        }

        return $this->twig->render('Admin/Member/edit.html.twig', [
            'member' => $member,
            'errors' => $errors ?? [],
            'success' => $_GET['success'] ?? null,
        ]);
    }


    /**
     * Display member creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add(): string
    {
        $member = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $memberManager = new MemberManager();
            $member = array_map('trim', $_POST);

            $errors = $this->validate($member);

            if (empty($errors)) {
                $memberManager->insert($member);
                header('Location:/AdminMember/index');
            }
        }

        return $this->twig->render('Admin/Member/add.html.twig', [
            'member' => $member,
            'errors' => $errors ?? [],
            'success' => $_GET['success'] ?? null,
        ]);
    }


    private function validate($data)
    {
        $emptyErrors = $this->validateEmpty($data);
        $errors = [];
        if (strlen($data['lastname']) > 155) {
            $errors['lastname'] = 'Le nom est trop long';
        }
        if (strlen($data['firstname']) > 155) {
            $errors['firstname'] = 'Le prénom est trop long';
        }
        if (strlen($data['function']) > 155) {
            $errors['function'] = 'La fonction est trop longue';
        }
        return array_merge($emptyErrors, $errors);
    }

    private function validateEmpty(array $data)
    {
        if (empty($data['lastname'])) {
            $errors['lastname'] = 'Le nom doit être indiqué';
        }
        if (empty($data['firstname'])) {
            $errors['firstname'] = 'Le prénom doit être indiqué';
        }
        if (empty($data['function'])) {
            $errors['function'] = 'Une fonction doit être renseignée';
        }
        if (empty($data['picture'])) {
            $errors['picture'] = 'Un nom d\'image doit être renseignée';
        }
        return $errors ?? [];
    }
}
