<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Voiture;
use App\Entity\Offre;
use App\Form\CarType;
use App\Form\OffreType;


class CarController extends AbstractController
{
    /**
     * @Route("/car", name="car")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Voiture::class);

        $voitures = $repo->findAll();    

        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
            'voitures' => $voitures,
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render("car/home.html.twig", [
            'nom_complet' => "Porsche 911 2018"
        ]);
    }

    /**
     * @Route("/car/new", name="car_newCar")
     * @Route("/car/{id}/edit", name="car_edit")
     */
    public function formCar(Voiture $voiture = null, Request $request, ManagerRegistry $manager) {
        
        if(!$voiture){
            $voiture = new Voiture();
        }


        $formCar = $this->createForm(CarType::class, $voiture);

        $formCar->handleRequest($request);

        if($formCar->isSubmitted() && $formCar->isValid()) {

            if (!$voiture->getId()){
                $voiture->setMiseEnVente(new \Datetime());
            }
            $manager->getManager()->persist($voiture);
            $manager->getManager()->flush();
            
            return $this->redirectToRoute('car_more', ['id' => $voiture->getId()]);
        }

        return $this->render('car/newCar.html.twig',[
            'formCar' => $formCar->createView(),
            'editMode' => $voiture->getId() !== null
        ]);
    }

    /**
     * @Route("/car/{id}/delete", name="car_delete")
     * 
     * @return Response
     */

    public function delete(Voiture $voiture){
        $sup = $this->getDoctrine()->getManager();
        $sup->remove($voiture);
        $sup->flush();

        return new Response('Voiture retirée de la vente.');
    }

    /**
    * @Route ("/car/{id}/offre", name="car_offre")
    */

   public function formOffre($id, Offre $offre = null, Request $request, ManagerRegistry $manager) {

       $repo = $this->getDoctrine()->getRepository(Voiture::class);

       $voiture = $repo->find($id);

       $offre = new Offre();

       $formOffre = $this->createForm(OffreType::class, $offre);

       $formOffre->handleRequest($request);

       if($formOffre->isSubmitted() && $formOffre->isValid()) {

            $offre->setCreatedAt(new \DateTimeImmutable());
            $offre->setVoiture($voiture);

           /*if (!$offre->getId()){
               $offre->CreatedAt(new \Datetime());
           }*/
           $manager->getManager()->persist($offre);
           $manager->getManager()->flush();
           
           return $this->redirectToRoute('car');
       }

       return $this->render('car/offre.html.twig',[
           'formOffre' => $formOffre->createView(),
           'voiture' => $voiture
       ]);
   }
    
    /**
     * @Route ("/car/{id}", name="car_more")
     */
    public function more($id,Offre $offre = null, Request $request, ManagerRegistry $manager) {
        $repo = $this->getDoctrine()->getRepository(Voiture::class);

        $voiture = $repo->find($id);

        return $this->render('car/more.html.twig', [
            'voiture' => $voiture
        ]);
    }


}
