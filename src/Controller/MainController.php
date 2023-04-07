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
<<<<<<< HEAD
        /* $this->denyAccessUnlessGranted('ROLE_ADMIN');*/
=======
>>>>>>> d9f6fd86d2c39aa24b599a7906f13c7e8ad8aab5
        // $this->denyAccessUnlessGranted(['ROLE_EDIT', 'ROLE_ADMIN']);
        // return $this->render('main/index.html.twig', [
        // 'category' => $categoryRepository->findBy(
        //  [],
        // ['categoryOrder' => 'asc']
        //  )
        //]);

        // $allCampaigns = $doctrine->getRepository(Campaign::class)->findAll();
        return $this->redirectToRoute('app_login');
        return $this->render('main/index.html.twig');
    }
};
