<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter

#[Route('/profil', name: 'app_profile_')]
class ProfileController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    #[Route('/commandes', name: 'orders')]
    public function orders(): Response
    {
        return $this->render('profile/orders.html.twig', [
            'controller_name' => 'Mes commandes',
        ]);
    }

    #[Route('/modif', name: 'edit')]
    public function editProfile(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            $this->addFlash('message', 'Profil mis à jour');

            return $this->redirectToRoute('app_profile_index');
        }

        return $this->render('profile/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/supprimer', name: 'delete')]
    // public function deleteProfile(): Response
    // {
    //     $user = $this->getUser();

    //     if ($user) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($user);
    //         $entityManager->flush();


    //         return $this->redirectToRoute('profile/deleteConfirmation.html.twig');
    //     } else {
    //         throw $this->createNotFoundException('Utilisateur non trouvé.');
    //     }
    // }
}
