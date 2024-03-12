<?php

namespace App\tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationsRepositoryTest
 *
 * @author hmagn
 */
class FormationsRepositoryTest extends KernelTestCase {
    
    /**
     * Recupere le repository de formations
     * @Return FormationRepository
     */
    public function recupRepository(): FormationRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    
    public function newFormation(): Formation{
        $formation = (new Formation())
                ->setTitle("nouvelle formation")
                ->setDescription("nouvelle description")
                ->setPublishedAt(new \DateTime("today"));
        return $formation;
    }
    
    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormations = $repository->count([]);
        $repository->add($formation, true);
        $this->assertEquals($nbFormations + 1, $repository->count([]), "erreur lors de l'ajout");
        
    }
    
    public function testSupprFormation(){
        $repository = $this->recupRepository();
        $formation = $repository->findOneBy(['title' => "nouvelle formation"]);
        $nbFormations = $repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormations - 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    
    public function testFindAllOrderBy(){
        $repository = $this->recupRepository();
        $formations = $repository->findAllOrderBy("title", "ASC");
        $nbFormations = count($formations);
        $this->assertEquals(237, $nbFormations);
    }
    
    
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $formations = $repository->findByContainValue("title", "C#");
        $nbFormations = count($formations);
        $this->assertEquals(11, $nbFormations);
    }
    
     
     public function testFindAllLasted(){
        $repository = $this->recupRepository();
        $formations = $repository->findAllLasted(1);
        $nbFormations = count($formations);
        $this->assertEquals(1, $nbFormations);
    }
      
    public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $formations = $repository->findAllForOnePlaylist(3);
        $nbFormations = count($formations);
        $this->assertEquals(19, $nbFormations);
    }
    
}
    

