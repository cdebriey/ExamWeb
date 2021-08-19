<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class ApiCarController extends AbstractController
{
    /**
     * @Route("/api/car", name="api_car_index", methods={"GET"})
     */
    public function index(VoitureRepository $VoitureRepository, NormalizerInterface $normalizer): Response
    {
        //$voitures = $VoitureRepository->findAll();

        /*$voituresNormalises = $normalizer->normalize($voitures, null, ['groups'=>'voiture:read']);

        $json = json_encode($voituresNormalises);*/

        return $this->json($VoitureRepository->findAll(), 200, [], ['groups'=>'voiture:read']);

        /*$response = new Response($json, 200, [
            "Content-Type"=>"application/json"
        ]); */

        //return $response;
    }


    /**
     * @Route("/api/car", name="api_car_store", methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, ValidatorInterface $validator){
        $jsonincoming = $request->getContent();

        try{
            $voiture = $serializer->deserialize($jsonincoming, Voiture::class,'json');
            $voiture->setMiseEnVente(new \DateTime());
            $errors = $validator->validate($voiture);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $manager->persist($voiture);
            $manager->flush();

            return $this->json($voiture, 201, [], ['groups'=>'voiture:read']);

        }

        catch (NotEncodableValueException $e) {
            return $this->json([
                'status'=>400,
                'message'=>$e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("/api/car/delete/{id}", name="api_car_delete", methods={"DELETE","OPTIONS"})
     */
    public function delete($id, VoitureRepository $voitureRepository, EntityManagerInterface $em)
    {

        $toDelete = $voitureRepository->find($id);

        $em->remove($toDelete);
        $em->flush();

        $message = "La voiture a bien été retirée de la vente.";

        $response = new JsonResponse(['message' => $message]);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With', true);

        return $response;
    }
}
