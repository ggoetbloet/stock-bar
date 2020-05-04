<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/", name="index_product")
     */
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/{slug}", name="show_product")
     */
    public function show( $slug, ProductRepository $productRepository)
    {
        $product = $productRepository->findOneBySlug($slug);

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
