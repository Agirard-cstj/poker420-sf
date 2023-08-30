<?php

namespace App\Controller;

use App\Entity\Joueur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\DBAL\Connection; // Pour avoir accès à l'engin de query
use Doctrine\Persistence\ManagerRegistry; // Pour l'accès à l'entityManager

ini_set('date.timezone','America/New_York');
header('Access-Control-Allow-Origin: *');


class ConnexionController extends AbstractController
{


    //-------------------------------------------
    //
    //-------------------------------------------
    #[Route('/getJoueurs')]
    public function getJoueurs(Connection $connection): JsonResponse
    {
        $joueurs =$connection->fetchAllAssociative('select * from joueur');
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
    public function creationCompte(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        // initialisation par le POST
        $nom = $request->request->get('nom');
        $mdp = $request->request->get('mdp');
        $courriel = $request->request->get('courriel');

        if($this->infoValides($nom, $mdp, $courriel)){
            $creation = new \DateTime();
            $nbLogin =1;
            
            if($request->getMethod() =='POST'){
                $em = $doctrine->getManager();
                $j= new Joueur();
                $j->setNom($nom);
                $j->setCourriel($courriel);
                $j->setMotDePasse($mdp);
                $j->setNbLogin(1);
                $j->setCreation($creation);
                $j->setDernierLogin($creation);
                $em->persist($j);
                $em->flush();


                $retJoueur['id']=$j->getId();
                $retJoueur['nom']=$j->getNom();
                $retJoueur['courriel']=$j->getCourriel();
                
                return $this->json($retJoueur);
        
            } else{
                return $this->json("erreur 62");
            }
           
        } else{
            return $this->json("erreur 66");
        };
        


    }


    
    //-------------------------------------------
    //
    //-------------------------------------------
    function infoValides($n, $mdp,$c){
        return true;
    }



    //-------------------------------------------
    //
    //-------------------------------------------
    #[Route('/connectionJoueur')]
    public function index(Request $req, ManagerRegistry $doctrine, Connection $connection): JsonResponse
    {
        // initialisation par le POST
        $nom = $req->request->get('nom');
        $mdp = $req->request->get('mdp');
        
        $joueur = $connection->fetchAllAssociative("select * from joueur where nom='$nom'");

        if (isset($joueur[0])){
            if($joueur[0]['motDePasse'] === $mdp){

                $retJoueur['id']= $joueur[0]['id'];
                $retJoueur['nom']=$joueur[0]['nom'];
                $retJoueur['courriel']=$joueur[0]['courriel'];

                return $this->json($retJoueur);
            }
            else{
                return $this->json("erreur 112");
            }
        }
        else{
            return $this->json($req);
        }

    }

}
