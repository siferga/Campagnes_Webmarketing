<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/utilisateur', name: 'admin_user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        /* $this->denyAccessUnlessGranted('ROLE_ADMIN');*/
        //ajouter ici une liste utilisateurs si desiré
        $allUsers = $doctrine->getRepository(User::class)->findAll();
        $user = $doctrine->getRepository(User::class)->findAll();
        return $this->render('admin/user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'allUsers' => $allUsers,
        ]);
    }


    #[Route('search/{id}', name: 'search')]
    public function search(ManagerRegistry $doctrine)
    {
        // on appele un produit par son id 
        $user = $doctrine()->getRepository(User::class)->findById;

        return $this->render('admin/user/search.html.twig', [
            'user' => $user
        ]);
    }


    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');

        //New user creation
        $user = new User();

        // form creation
        $registrationForm = $this->createForm(RegistrationFormType::class, $user);

        // Form request
        $registrationForm->handleRequest($request);

        //verificate if Form ies submitted and valid 
        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {

            // On stocke
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Utilisateur ajouté avec succès');

            // On redirige vers ou? index?
            return $this->redirectToRoute('admin_user_index');
        }


        return $this->render('admin/user/add.html.twig', [
            //IMPORTANT
            //à regarder car je crois que il faut mettre 'registartionForm' à la place de 'userForm' car je l'ai vu ailleur.
            //
            'registrationForm' => $registrationForm->createView()
        ]);

        // return $this->renderForm('admin/user/add.html.twig', compact('userForm'));
        // ['userForm' => $userForm]
    }


    #[Route('/edition/{id}', name: 'edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        // On vérifie si l'utilisateur peut éditer avec le Voter
        // $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // On crée le formulaire
        $userForm = $this->createForm(RegistrationFormType::class, $user);

        // On traite la requête du formulaire
        $userForm->handleRequest($request);

        //On vérifie si le formulaire est soumis ET valide
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // On génère le slug
            // $slug = $slugger->slug($user->getLastname());
            // $user->setSlug($slug);

            // On arrondit le prix 
            // $prix = $product->getPrice() * 100;
            //$product->setPrice($prix);

            // stocker
            $em->persist($user);
            $em->flush();

            //message flash _partials.
            $this->addFlash('success', 'Usuaire modifié avec succès');

            // On redirige
            return $this->redirectToRoute('admin_user_index');
        }


        return $this->render('admin/user/edit.html.twig', [
            'userForm' => $userForm->createView()
        ]);

        //return $this->renderForm('admin/products/edit.html.twig', compact('productForm'));
        // ['productForm' => $productForm]
    }
}
