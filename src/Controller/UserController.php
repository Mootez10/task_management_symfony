<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/', name: 'app_user')]
    public function listUsers(UserRepository $userRepository): Response
    {
        $listUsers = $userRepository->findAll();
        return $this->render('user/listUsers.html.twig', [
            'listUsers' => $listUsers,
        ]);
    }

    #[Route('/new', name: 'app_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/new.html.twig', [
            'formU' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'user_update')]
    public function edit(Request $request, EntityManagerInterface $em, UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            // Add a flash message
            $this->addFlash('success', 'User updated successfully');

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/edit.html.twig', [
            'formU' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'user_delete')]
    public function delete(EntityManagerInterface $em, UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'User deleted successfully');

        return $this->redirectToRoute('app_user');
    }
}
