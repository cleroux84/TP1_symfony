<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("/show", name="show")
     */
    public function index()
    {
        return $this->render('show/index.html.twig', [
            'controller_name' => 'ShowController',
        ]);
    }
}
