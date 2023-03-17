<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Category;
use App\Repository\CampaignRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/campagne', name: 'campaign_')]
class CampaignController extends AbstractController

{ //Display Campaign List (all)
    #[Route('/', name: 'index')]
    public function afficherCampagnes(ManagerRegistry $doctrine): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $allCampaigns = $doctrine->getRepository(Campaign::class)->findAll();
        return $this->render('campaign/index.html.twig', [
            'controller_name' => 'CampaignController',
            'campaign' => '$campaign',
            'allCampaigns' => $allCampaigns,
        ]);
    }

    /* #[Route('/details', name: 'details')]
    public function details(ManagerRegistry $doctrine): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');

        $allCampaigns = $doctrine->getRepository(Campaign::class)->findAll();
        return $this->render('campaign/details.html.twig', [
            'controller_name' => 'CampaignController',
            'campaign' => '$campaign',
            'allCampaigns' => $allCampaigns,
        ]);
    }*/

    //Display Campaign List by category (all)
    #[Route('/{slug}', name: 'details')]
    public function list(Category $category, CampaignRepository $campaignRepository, Request $request): Response
    {
        //On va chercher le numéro de page dans l'url
        //$page = $request->query->getInt('page', 1);

        //On va chercher la liste des produits de la catégorie
        //$products = $productsRepository->findProductsPaginated($page, $category->getSlug(), 4);

        //Cherche la liste des produits de la catégorie
        $campaign = $campaignRepository->getCampaign($category->getSlug());

        return $this->render('campaign/details.html.twig', [
            'category' => $category,
            'campaign' => $campaign
        ]);
    }
}
