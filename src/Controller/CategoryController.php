<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/categories/new", name="create_category")
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le categorie <strong>{$category->getName()}</strong> à bien été enregistrée !"
            );

            return $this->redirectToRoute('show_category', [
                'id' => $category->getId()
            ]);
        }

        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    } 

    /**
     * @Route("/product/edit/{id}", name="edit_category")
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, Category $category, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($category);
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le Category <strong>{$category->getName()}</strong> à bien été modifié !"
            );

            return $this->redirectToRoute('show_category', [
                'id' => $category->getId()
            ]);
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
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
