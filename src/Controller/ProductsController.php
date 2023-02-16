<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{ //Liste affiche campagnes

    #[Route('/', name: 'index')]
    public function afficherProduits(ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $allProducts = $doctrine->getRepository(Products::class)->findAll();

        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
            'product' => '$products',
            'allProducts' => $allProducts,
        ]);
    }

    #[Route('/details', name: 'details')]
    public function details(ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $allProducts = $doctrine->getRepository(Products::class)->findAll();
        return $this->render('products/details.html.twig', [
            'controller_name' => 'ProductsController',
            'product' => '$products',
            'allProducts' => $allProducts,
        ]);
    }

    #[Route('/{slug}', name: 'slug')]
    public function list(Categories $category, ProductsRepository $productsRepository, Request $request): Response
    {
        //On va chercher le numéro de page dans l'url
        //$page = $request->query->getInt('page', 1);

        //On va chercher la liste des produits de la catégorie
        //$products = $productsRepository->findProductsPaginated($page, $category->getSlug(), 4);

        //Cherche la liste des produits de la catégorie
        $products = $productsRepository->getProducts($category->getSlug());

        return $this->render('categories/list.html.twig', [
            'category' => $category,
            'products' => $products
        ]);
    }
}
