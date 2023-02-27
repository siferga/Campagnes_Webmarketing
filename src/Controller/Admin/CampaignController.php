<?php

namespace App\Controller\Admin;

use App\Entity\Campaign;
use App\Form\CampaignFormType;
use App\Repository\CategoryRepository;
use App\Repository\CampaignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/campagne', name: 'admin_campaign')]
class CampaignController extends AbstractController
{ //Liste affichage campagnes
    #[Route('/', name: '_index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        //Nous voulons afficher tous les produits
        $allCampaigns = $doctrine->getRepository(Campaign::class)->findAll();

        return $this->render('admin/campaign/index.html.twig', [
            'controller_name' => 'CampaignController',
            'campaign' => '$campaign',
            'allCampaigns' => $allCampaigns,
        ]);
    }


    #[Route('search/{id}', name: '_search')]
    public function search(ManagerRegistry $doctrine)
    {
        // on appele un produit par son id 
        $campaign = $doctrine()->getRepository(Campaign::class)->findById;

        return $this->render('admin/campaign/search.html.twig', [
            'campaign' => $campaign
        ]);
    }


    #[Route('/ajout', name: '_add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //On crée un "nouveau produit"
        $campaign = new Campaign();

        // On crée le formulaire
        $campaignForm = $this->createForm(CampaignFormType::class, $campaign);

        // Requête du formulaire
        $campaignForm->handleRequest($request);

        //On vérifie si le formulaire est soumis ET valide
        if ($campaignForm->isSubmitted() && $campaignForm->isValid()) {
            // On génère le slug
            $slug = $slugger->slug($campaign->getName());
            $campaign->setSlug($slug);

            // On arrondit le prix 
            $prix = $campaign->getPrice();
            $campaign->setPrice($prix);

            // On stocke
            $em->persist($campaign);
            $em->flush();

            $this->addFlash('success', 'Campagne ajouté avec succès');

            // On redirige
            return $this->redirectToRoute('admin_campaign_index');
        }


        return $this->render('admin/campaign/add.html.twig', [
            'campaignForm' => $campaignForm->createView()
        ]);

        // return $this->renderForm('admin/products/add.html.twig', compact('productForm'));
        // ['productForm' => $productForm]
    }

    #[Route('/edition/{id}', name: '_edit')]
    public function edit(Campaign $campaign, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        // On vérifie si l'utilisateur peut éditer avec le Voter
        // $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // On divise le prix par 100
        $prix = $campaign->getPrice() / 100;
        $campaign->setPrice($prix);

        // On crée le formulaire
        $campaignForm = $this->createForm(CampaignFormType::class, $campaign);

        // On traite la requête du formulaire
        $campaignForm->handleRequest($request);

        //On vérifie si le formulaire est soumis ET valide
        if ($campaignForm->isSubmitted() && $campaignForm->isValid()) {
            // On génère le slug
            $slug = $slugger->slug($campaign->getName());
            $campaign->setSlug($slug);

            // On arrondit le prix 
            // $prix = $campaign->getPrice() * 100;
            //$campaign->setPrice($prix);

            // stocker
            $em->persist($campaign);
            $em->flush();

            //message flash _partials.
            $this->addFlash('success', 'Campaigne modifié avec succès');

            // On redirige
            return $this->redirectToRoute('admin_campaign_index');
        }


        return $this->render('admin/campaign/edit.html.twig', [
            'campaignForm' => $campaignForm->createView()
        ]);

        //return $this->renderForm('admin/products/edit.html.twig', compact('campaignForm'));
        // ['campaignForm' => $campaignForm]
    }

    #[Route('/suppression/{id}', name: '_delete')]
    public function delete(Campaign $campaign): Response
    {
        // On vérifie si l'utilisateur peut supprimer avec le Voter
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $campaign);

        return $this->render('admin/campaign/index.html.twig');
    }
}
