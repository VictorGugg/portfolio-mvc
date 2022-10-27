<?php

namespace App\Controller;

use App\Model\ImageManager;

final class ImageController extends AbstractController
{
    /** Creating empty variables matching the form input
     * TODO add the url input
     */

    // public $title = '';
    // public $description = '';
    // public $url = '';

    /**
     * Creating an errors array, to store potential errors
     * and be able to report them to the user.
     */

    // public $errors = [];


    /**
     * Sanitization + error rendering function
     */

    // public function validation()
    // {
    //     if (
            /* Checking for an input, other than only spaces, of 200 or less characters */
        //     !isset($_POST['title'])
        //     || trim($_POST['title']) === ''
        //     || strlen($_POST['title']) > 200
        // ) {
        //     $errors[] = "title=1";
        // } else {
        //     return (string)$title = $this->sanitizeInput($_POST['title']);
        // }

        // if (
            /* Checking for an input, other than only spaces, of 1.000 or less characters */
        //     !isset($_POST['description'])
        //     || trim($_POST['description']) === ''
        //     || strlen($_POST['description']) > 1000
        // ) {
        //     $errors[] = "description=1";
        // } else {
        //     return (string)$description = $this->sanitizeInput($_POST['description']);
        // }

        // if (
            /* Checking for an input, other than only spaces, of 2048 or less characters */
        //     !isset($_POST['url'])
        //     || trim($_POST['url']) === ''
        //     || strlen($_POST['url']) > 2048
        // ) {
        //     $errors[] = "url=1";
        // } else {
        //     return (string)$url = $this->sanitizeInput($_POST['url']);
        // }

        /* Checking if there is errors and displaying the appropriate message(s) to the user */

    //     if (!empty($errors)) {
    //         $errorsJoined = join('&', $errors);
    //         header("Location: /add.php?errors=1&" . $errorsJoined);
    //     }

    //     if (isset($_GET['errors'])) {
    //         if (isset($_GET['title'])) {
    //             echo "Please enter a valid title (200 characters max).<br>";
    //         }

    //         if (isset($_GET['description'])) {
    //             echo "Please enter a valid lastname (1.000 characters max).<br>";
    //         }

    //         if (isset($_GET['url'])) {
    //             echo "Please enter a valid url (2.048 characters max).<br>";
    //         }
    //     }
    // }


    /**
     * List images
     * TODO : Display a miniature of the image
     */
    public function index(): string
    {
        $imageManager = new ImageManager();
        $images = $imageManager->selectAll('title');

        return $this->twig->render('_Image/index.html.twig', ['images' => $images]);
    }

    /**
     * Show informations for a specific image
     * TODO : Display the image, the title, its description, date and author
     */
    public function show(int $id): string
    {
        $imageManager = new ImageManager();
        $image = $imageManager->selectOneById($id);

        return $this->twig->render('_Image/show.html.twig', ['image' => $image]);
    }

    /**
     * Edit a specific image
     */
    public function edit(int $id): ?string
    {
        $imageManager = new ImageManager();
        $image = $imageManager->selectOneById($id);

        // Possibilité made in Yacine : factoriser en différentes fonctions
        // $data = [];
        // $data['title'] = resultOfMyValidation();
        // $imageInstance->setProperties($data);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $this->validation();
            $imageManager->update($image);

            header('Location: /images/show?id=' . $id);

            // we are redirecting so we don't want any content rendered
            return null;
        }

        return $this->twig->render('_Image/edit.html.twig', [
            'image' => $image,
        ]);
    }

    /**
     * Add a new image
     */
    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $image = array_map('trim', $_POST);
            // $this->validation();

            // if validation is ok, insert and redirection
            $imageManager = new ImageManager();
            $id = $imageManager->insert($image);

            header('Location:/images/show?id=' . $id);
            return null;
        }

        return $this->twig->render('_Image/add.html.twig');
    }

    /**
     * Delete a specific image
     */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $imageManager = new ImageManager();
            $imageManager->delete((int)$id);

            header('Location:/images');
        }
    }
}
