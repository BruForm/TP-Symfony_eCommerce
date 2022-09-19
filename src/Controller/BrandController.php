<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends AbstractController
{
    #[Route('/brands', name: 'app_brand')]
    public function index(BrandRepository $brandRepository): Response
    {
        return $this->render('brand/brands.html.twig', [
            'brands' => $brandRepository->findAll(),
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
