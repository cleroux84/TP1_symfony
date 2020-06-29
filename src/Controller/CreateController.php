<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function index()
    {
        return $this->render('create/index.html.twig', [
            'controller_name' => 'CreateController',
        ]);
    }
}
