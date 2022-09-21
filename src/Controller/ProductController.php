<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductFilterType;
use App\Form\ProductType;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isNull;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_product')]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filterName = $form->get('filterOnName')->getData();
            $filterPrice = $form->get('filterOnPrice')->getData();
            if (is_null($filterPrice)) {$filterPrice = 0;}
            $products = $productRepository->findAllFilteredByNamePrice($filterName, $filterPrice);
        } else {
            $products = $productRepository->findAll();
        }
//        $products = $productRepository->findAllPricesGT(50);

        return $this->render('product/products.html.twig', [
            'productFilter' => $form->createView(),
            'products' => $products
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
