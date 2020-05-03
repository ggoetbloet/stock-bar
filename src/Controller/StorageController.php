<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StorageController extends AbstractController
{
    /**
     * @Route("/storage", name="storage")
     */
    public function index()
    {
        return $this->render('storage/index.html.twig', [
            'controller_name' => 'StorageController',
        ]);
    }
}
