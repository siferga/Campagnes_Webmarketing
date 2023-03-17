<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    //#[Route('/', name: 'main', methods: ['GET'])]
    #[Route('/', name: 'main')]
    public function index(): Response
    {
        /* $this->denyAccessUnlessGranted('ROLE_ADMIN');*/
        // $this->denyAccessUnlessGranted(['ROLE_EDIT', 'ROLE_ADMIN']);
        // return $this->render('main/index.html.twig', [
        // 'category' => $categoryRepository->findBy(
        //  [],
        // ['categoryOrder' => 'asc']
        //  )
        //]);

        // $allCampaigns = $doctrine->getRepository(Campaign::class)->findAll();

        return $this->render('main/index.html.twig');
    }
};
