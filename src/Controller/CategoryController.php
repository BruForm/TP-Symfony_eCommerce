<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFilterType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_category')]
    public function index(Request $request, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('filterOnName')->getData();
            $categories = $categoryRepository->findAllFilteredByName($search);
        } else {
            $categories = $categoryRepository->findAll();
        }

        return $this->render('category/categories.html.twig', [
            'categoryFilter' => $form->createView(),
            'categories' => $categories,
        ]);
    }

    #[Route('/category/new', name: 'app_category_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La categorie ' . $category->getName() . ' a été créée !');

            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/categoryNew.html.twig', [
            'categForm' => $form->createView(),
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_details')]
    public function showDetails(Category $category): Response
    {
        return $this->render('category/categoryDetails.html.twig', [
            'category' => $category,
        ]);
    }
}
