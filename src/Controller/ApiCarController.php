<?php

namespace App\Controller;

use DateTime;
use App\Entity\Voiture;
use Doctrine\ORM\EntityManager;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;


class ApiCarController extends AbstractController
{
    /**
     * @Route("/api/car", name="api_car_index", methods={"GET"})
     */
    public function index(VoitureRepository $VoitureRepository, NormalizerInterface $normalizer): Response
    {

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With', true);

        $em = $this->getDoctrine()->getManager();
        $voitures = $em->getRepository(Voiture::class)->findAll();

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $content = $serializer->serialize($voitures, 'json', [
            'circular_reference_handler' => function ($voitures) {
                return $voitures->getId();
            }
        ], ['groups'=>'voiture:read']);

        $response->setContent($content);

        return $response;
        
        
        //return $this->json($VoitureRepository->findAll(), 200, [], ['groups'=>'voiture:read']);

    }


    /**
     * @Route("/api/car", name="api_car_store", methods={"POST","OPTIONS"})
     */
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, ValidatorInterface $validator){
        
        $jsonincoming = $request->getContent();

        try{
            $voiture = $serializer->deserialize($jsonincoming, Voiture::class,'json');
            $voiture->setMiseEnVente(new \DateTime());
            //$errors = $validator->validate($voiture);

            /*if (count($errors) > 0) {
                return $this->json($errors, 400);
            }*/

            $manager->persist($voiture);
            $manager->flush();

            $response = new JsonResponse();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With', true);

            //return $this->json($voiture, 201, [], ['groups'=>'voiture:read']);
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $content = $serializer->serialize($voiture, 'json', [
                'circular_reference_handler' => function ($voiture) {
                    return $voiture->getId();
                }
            ]);

            $response->setContent($content);
    
            return $response;

        }

        catch (NotEncodableValueException $e) {
            /*return $this->json([
                'status'=>400,
                'message'=>$e->getMessage()
            ], 400);*/
            $response = new JsonResponse(['status' => 400, 'message' => $e->getMessage()]);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With', true);

            return $response;
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

        /**
     * @Route("/api/car/{id}", name="api_car_put", methods={"PUT","OPTIONS"})
     */

    public function put($id, Request $request, VoitureRepository $voitureRepository, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $em)
    {


        $jsonReceived = $request->getContent();
        $toModify = $voitureRepository->find($id);

        try {
            $deserializedReceived = $serializer->deserialize($jsonReceived, Voiture::class, 'json');
            $toModify->setMarque($deserializedReceived->getMarque());
            $toModify->setModele($deserializedReceived->getModele());
            $toModify->setImage($deserializedReceived->getImage());
            $toModify->setAnneeDeMiseEnCirculation($deserializedReceived->getAnneeDeMiseEnCirculation());
            $toModify->setCylindree($deserializedReceived->getCylindree());
            $toModify->setPuissance($deserializedReceived->getPuissance());
            $toModify->setKilometrage($deserializedReceived->getKilometrage());
            $toModify->setPrixDemande($deserializedReceived->getPrixDemande());
            $toModify->setDescription($deserializedReceived->getDescription());

            
            $errors = $validator->validate($deserializedReceived);

            // vérification des erreurs
            if (count($errors) > 0) {

                $response = new JsonResponse(['message' => $errors]);
                $response->headers->set('Content-Type', 'application/json');
                $response->headers->set('Access-Control-Allow-Origin', '*');
                $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
                $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With', true);

                return $response;
            }

            $em->persist($toModify);
            $em->flush();

            $message = "Les changements de votre annonce ont bien été enregistrés!";

            $response = new JsonResponse(['message' => $message]);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With', true);

            return $response;

        } catch (NotEncodableValueException $e) {

            $response = new JsonResponse(['status' => 400, 'message' => $e->getMessage()]);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With', true);

            return $response;
        }
    }
    /**
     * @Route("/api/car/{id}", name="api_car_id", methods={"GET","OPTIONS"})
     */
    public function car($id): Response
    {

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With', true);

        $em = $this->getDoctrine()->getManager();
        $voitures = $em->getRepository(Voiture::class)->find($id);

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $content = $serializer->serialize($voitures, 'json', [
            'circular_reference_handler' => function ($voitures) {
                return $voitures->getId();
            }
        ]);

        $response->setContent($content);

        return $response;

        //return $this->json($voitureRepository->find($id), 200, [], ['groups' => 'voiture:read']);
    }
}

