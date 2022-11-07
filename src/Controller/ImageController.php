<?php

namespace App\Controller;

use App\Model\ImageManager;

final class ImageController extends AbstractController
{
    public const TITLE_INPUT = 'title';
    public const DESCRIPTION_INPUT = 'description';
    public const URL_INPUT = 'url';

    public const DB_TITLE_MAX_LENGTH = 200;
    public const DB_DESCRIPTION_MAX_LENGTH = 1000;
    public const DB_URL_MAX_LENGTH = 2048;

    public function validateInput($inputType, $inputLength)
    {
        $errors = [];
        if (
            !isset($_POST["$inputType"])
            || trim($_POST["$inputType"]) === ''
            || strlen($_POST["$inputType"]) > $inputLength
            // ! TODO make this RegEx functionnal
            // || preg_match("^[a-zA-Z0-9.,:!?()\-\"'\s]*$^", $_POST["$inputType"])
        ) {
            $errors[$inputType] = true;
        }
        return $errors;
    }

    public function validateInputs()
    {
        $errors = array_merge(
            $this->validateInput(self::TITLE_INPUT, self::DB_TITLE_MAX_LENGTH),
            $this->validateInput(self::DESCRIPTION_INPUT, self::DB_DESCRIPTION_MAX_LENGTH),
            $this->validateInput(self::URL_INPUT, self::DB_URL_MAX_LENGTH)
        );
        return $errors;
    }

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
        $updatedImage = $imageManager->selectOneById($id);
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ! TODO think of validating that the id/image exists
            $errors = $this->validateInputs();
            if (empty($errors)) {
                $updatedImage = $imageManager->update([
                    'id' => $this->sanitizeInput($_POST['id']),
                    'title' => $this->sanitizeInput($_POST['title']),
                    'description' => $this->sanitizeInput($_POST['description']),
                    'url' => $this->sanitizeInput($_POST['url'])
                ]);
                header('Location: /images/show?id=' . $_POST['id']);
                // we are redirecting so we don't want any content rendered
                return '';
            }
        }
        return $this->twig->render('_Image/edit.html.twig', [
            'image' => $updatedImage,
            'errors' => $errors
        ]);
    }

    /**
     * Add a new image
     */
    public function add(): ?string
    {
        $imageManager = new ImageManager();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateInputs();
            if (empty($errors)) {
                $id = $imageManager->insert([
                    'title' => $this->sanitizeInput($_POST['title']),
                    'description' => $this->sanitizeInput($_POST['description']),
                    'url' => $this->sanitizeInput($_POST['url'])
                ]);
                header('Location: /images/show?id=' . $id);
                return '';
            }
        }
        return $this->twig->render('_Image/add.html.twig', [
            // TODO add the user input to the return, to save the user input in the form in case of errors.
            'errors' => $errors
        ]);
    }

    /**
     * Delete a specific image
     */
    public function delete(): void
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['id'])
            && ctype_digit($_POST['id'])
        ) {
            $id = trim($_POST['id']);
            $imageManager = new ImageManager();
            $imageManager->delete((int)$id);

            header('Location:/images');
        } else {
            // TODO : redirect to /error page
            header('Location:/images');
        }
    }
}
