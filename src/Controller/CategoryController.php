<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CampaignRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categories')]
class CategoryController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function afficherCategories(ManagerRegistry $doctrine): Response
    {
        $allCategories = $doctrine->getRepository(Categories::class)->findAll();

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
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
    public function list(Category $category, CampaignRepository $campaignRepository, Request $request): Response
    {
        //On va chercher le numéro de page dans l'url
        //$page = $request->query->getInt('page', 1);

        //On va chercher la liste des produits de la catégorie
        //$campaign = $campaignRepository->findProductsPaginated($page, $category->getSlug(), 4);

        //Cherche la liste des produits de la catégorie
        $campaign = $campaignRepository->getCampaign($category->getSlug());

        return $this->render('category/list.html.twig', [
            'category' => $category,
            'campaign' => $campaign
        ]);
    }
}
