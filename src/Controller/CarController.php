<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\CarType;
use App\Entity\Voiture;
use App\Form\OffreType;
use App\Form\SearchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    public function home(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Voiture::class);

        $voitures = $repo->findAll();    

        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
            'voitures' => $voitures,
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
                $this->addFlash(
                    'notice',
                    'Votre voiture a bien été mise en vente!'
                );
            }
            else{
                $this->addFlash(
                    'notice',
                    'Les changements ont bien été enregistrés !'
                );
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

        $this->addFlash(
            'notice',
            'La voiture a bien été retirée de la vente!'
        );

        //return new Response('Voiture retirée de la vente.')
        return $this->redirectToRoute('car');
    }

    /**
     * @Route("/car/{id}/deleteOffre", name="car_deleteOffre")
     * 
     * @return Response
     */

    public function deleteOffre($id, Offre $offre){
        $repo = $this->getDoctrine()->getRepository(Offre::class);
        $voiture = $repo->find($id);
        $sup = $this->getDoctrine()->getManager();
        $sup->remove($offre);
        $sup->flush();

        $this->addFlash(
            'notice',
            'L\'offre a bien été retirée !'
        );

        //return new Response('Voiture retirée de la vente.')
        return $this->redirectToRoute('car');
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

            $offre->setCreatedAt(new \DateTime());
            $offre->setVoiture($voiture);
           $manager->getManager()->persist($offre);
           $manager->getManager()->flush();

           $this->addFlash(
            'notice',
            'Votre offre a bien été enregistrée!'
            );
           
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
    /**
    * @Route("/search",name="search")
    */

    public function search(Request $request) {

    $repo = $this ->getDoctrine()->getRepository(Voiture::class);
    $voitures = $repo -> findAll();
    $form = $this->createForm(SearchType::class);

    $form ->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
        return $this->render('car/search_result.html.twig', [
            'voitureResearch' => $request->request->get('search'), 
            'voitures' => $voitures
            ]);
        }
    return $this ->render('car/search_form.html.twig',[
        'formResearch' => $form->createView()
        ]);
    }

}
