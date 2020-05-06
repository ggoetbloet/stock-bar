<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/product/new", name="create_product")
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($product);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le Produit <strong>{$product->getName()}</strong> à bien été enregistrée !"
            );

            return $this->redirectToRoute('show_product', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    } 

    /**
     * @Route("/product/edit/{id}", name="edit_product")
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, Product $product, ProductRepository $productRepository)
    {
        $product = $productRepository->find($product);
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($product);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le Produit <strong>{$product->getName()}</strong> à bien été modifié !"
            );

            return $this->redirectToRoute('show_product', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    } 

    /**
     * @Route("/product/{id}", name="show_product", requirements={"id":"[0-9\-]*", "slug":"[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Product $product, ProductRepository $productRepository)
    {
        $product = $productRepository->find($product);

        $qrCode = new QrCode();
        $qrCode
        ->setText("http://localhost:8000/product/".$product->getid())
        ->setSize(200)
        ->setPadding(10)
        ->setErrorCorrection('high')
        ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
        ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
        ->setLabel($product->getid())
        ->setLabelFontSize(16)
        ->setImageType(QrCode::IMAGE_TYPE_PNG)
        ;
        $barCode = $qrCode->generate();
        

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'barCode' => $barCode
        ]);
    }

    
}
