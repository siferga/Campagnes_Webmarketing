<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/categorie', name: 'admin_category')]
class CategoryController extends AbstractController
{

    #[Route('/', name: '_index',)]
    //Rcuperer le categorieRepository
    public function index(CategoryRepository $categoryRepository): Response
    { //pas de criteres, nous récuperons tout par asc category order 
        $allCategories = $categoryRepository->findBy([], ['categoryOrder' => 'asc']);

        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => '$category',
            'allCategories' => $allCategories,
        ]); //On va chercher le numéro de page dans l'url
    }
};
