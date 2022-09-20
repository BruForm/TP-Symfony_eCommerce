<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/products.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

//    #[Route('/product/create', name: 'app_product_new')]
//    public function new(Request $request, EntityManagerInterface $entityManager, BrandRepository $brandRepository, CategoryRepository $categoryRepository): Response
//    {
//        if ($request->request->has('name')) {
//            $newProduct = new Product();
//            $newProduct->setName($request->request->get('name'))
//                ->setDescription($request->request->get('description'))
//                ->setPrice($request->request->get('price'))
//
//            $entityManager->persist($newProduct);
//            $entityManager->flush();
//        }
//
//        return $this->render('product/new.html.twig', [
//            'brands' => $brandRepository->findAll(),
//            'categories' => $categoryRepository->findAll(),
//        ]);
//    }
    #[Route('/product/new', name: 'app_product_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit ' . $product->getName() . ' a été créée !');

            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/newProduct.html.twig', [
            'productForm' => $form->createView(),
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_details')]
    public function showDetails(Product $product): Response
    {
        return $this->render('product/productDetails.html.twig', [
            'product' => $product,
        ]);
    }
}
