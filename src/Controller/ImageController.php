<?php

namespace App\Controller;

use App\Model\ImageManager;

class ImageController extends AbstractController
{
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $image = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
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

            // TODO validations (length, format...)

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
