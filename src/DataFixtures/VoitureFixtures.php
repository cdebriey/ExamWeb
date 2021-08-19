<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Voiture;

class VoitureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <=4; $i++){
            $voiture= new Voiture();
            $voiture->setMarque("Nom de la voiture n°$i")
                    ->setDescription("<p>Voici la voiture n°$i</p>")
                    ->setImage("https://files.porsche.com/filestore/image/multimedia/none/911-tus-modelimage-sideshot/model/930894f1-6214-11ea-80c8-005056bbdc38/porsche-model.png")
                    ->setKilometrage(10000*$i)
                    ->setMiseEnVente(new \DateTime())
                    ->setCylindree(100*$i)
                    ->setPrixDemande(15000*$i);
                    
            $manager->persist($voiture);

        }

        $manager->flush();
    }
}
