<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    
    #[Route('/users/all', methods: ['GET'])]
    public function getUsersAction(): JsonResponse
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        
        // Преобразуем пользователей в массив
        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
              'id' => $user->getId(),
              'name' => $user->getName(),
              'phone' => $user->getPhone(),
              'city' => $user->getCity(),
              'password' => $user->getPassword()
            ];
        }
        
        return new JsonResponse($userData);
    }
}
