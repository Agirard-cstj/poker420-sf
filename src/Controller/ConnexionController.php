<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\DBAL\Connection; // Pour avoir accès à l'engin de query

header('Access-Control-Allow-Origin: *');

class ConnexionController extends AbstractController
{


    //-------------------------------------------
    //
    //-------------------------------------------
    #[Route('/getJoueurs')]
    public function getJoueurs(Connection $connection): JsonResponse
    {
        $joueurs =$connection->fetchAllAssociative('select * from joueurs');
        return $this->json($joueurs);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ConnexionController.php',
        ]);
    }



    //-------------------------------------------
    //
    //-------------------------------------------
    #[Route('/creationCompte')]
    public function creationCompte(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ConnexionController.php',
        ]);
    }



    //-------------------------------------------
    //
    //-------------------------------------------
    #[Route('/connexion', name: 'app_connexion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ConnexionController.php',
        ]);
    }
}
