<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandFilterType;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends AbstractController
{
    #[Route('/brands', name: 'app_brand')]
    public function brands(Request $request, BrandRepository $brandRepository): Response
    {
        $form = $this->createForm(BrandFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('filterOnName')->getData();
            $brands = $brandRepository->findAllFilteredByName($search);
        } else {
            $brands = $brandRepository->findAll();
        }

        return $this->render('brand/brands.html.twig', [
            'brandFilter' => $form->createView(),
            'brands' => $brands,
        ]);
    }

    #[Route('/brand/new', name: 'app_brand_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brand);
            $entityManager->flush();

            $this->addFlash('success', 'La marque ' . $brand->getName() . ' a été créée !');

            return $this->redirectToRoute('app_brand');
        }

        return $this->render('brand/brandNew.html.twig', [
            'brandForm' => $form->createView(),
        ]);
    }

    #[Route('/brand/{id}', name: 'app_brand_details')]
    public function showDetails(Brand $brand): Response
    {
        return $this->render('brand/brandDetails.html.twig', [
            'brand' => $brand,
        ]);
    }
}
