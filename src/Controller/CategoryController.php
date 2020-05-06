<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="index_category")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{id}", name="show_category")
     */
    public function show($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
