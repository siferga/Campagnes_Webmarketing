<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/utilisateurs', name: 'admin_users_')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        //ajouter ici une liste utilisateurs si desiré
        $allUsers = $doctrine->getRepository(Users::class)->findAll();

        return $this->render('admin/users/index.html.twig', [
            'controller_name' => 'UsersController',
            'user' => '$users',
            'allUsers' => $allUsers,
        ]);
    }


    // #[Route('/liste', name: 'list')]
    //public function list(): Response
    // {
    //ajouter ici une liste utilisateurs si desiré
    //return $this->render('admin/users/index.html.twig');
    // }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //On crée un "nouveau produit"
        $user = new Users();

        // On crée le formulaire
        $registrationForm = $this->createForm(RegistrationFormType::class, $user);

        // Requête du formulaire
        $registrationForm->handleRequest($request);

        //On vérifie si le formulaire est soumis ET valide
        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {

            // On stocke
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Utilisateur ajouté avec succès');

            // On redirige
            return $this->redirectToRoute('admin_users_index');
        }


        return $this->render('admin/users/add.html.twig', [
            'userForm' => $registrationForm->createView()
        ]);

        // return $this->renderForm('admin/products/add.html.twig', compact('productForm'));
        // ['productForm' => $productForm]
    }


    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Users $users, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        // On vérifie si l'utilisateur peut éditer avec le Voter
        // $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // On crée le formulaire
        $userForm = $this->createForm(RegistrationFormType::class, $users);

        // On traite la requête du formulaire
        $userForm->handleRequest($request);

        //On vérifie si le formulaire est soumis ET valide
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // On génère le slug
            // $slug = $slugger->slug($users->getLastname());
            // $users->setSlug($slug);

            // On arrondit le prix 
            // $prix = $product->getPrice() * 100;
            //$product->setPrice($prix);

            // stocker
            $em->persist($users);
            $em->flush();

            //message flash _partials.
            $this->addFlash('success', 'Usuaire modifié avec succès');

            // On redirige
            return $this->redirectToRoute('admin_users_index');
        }


        return $this->render('admin/users/edit.html.twig', [
            'userForm' => $userForm->createView()
        ]);

        //return $this->renderForm('admin/products/edit.html.twig', compact('productForm'));
        // ['productForm' => $productForm]
    }
}
