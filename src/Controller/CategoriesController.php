<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categories')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function afficherCategories(ManagerRegistry $doctrine): Response
    {
        $allCategories = $doctrine->getRepository(Categories::class)->findAll();

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'category' => '$category',
            'allCategories' => $allCategories,
        ]); //On va chercher le numéro de page dans l'url
        //$page = $request->query->getInt('page', 1);

        //On va chercher la liste des produits de la catégorie
        //$products = $productsRepository->findProductsPaginated($page, $category->getSlug(), 4);

        //On va chercher la liste des produits de la catégorie
        //$products = $category->getProducts();

        //return $this->render('categories/list.html.twig', [
        //'category' => $category,
        // 'products' => $products
        //]);
    }

    #[Route('/{slug}', name: '_list')]
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
