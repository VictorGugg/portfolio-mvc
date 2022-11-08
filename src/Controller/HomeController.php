<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $dataForm = ['function' => 'images/add'];
        return $this->twig->render('Home/index.html.twig', $dataForm);
    }
}
