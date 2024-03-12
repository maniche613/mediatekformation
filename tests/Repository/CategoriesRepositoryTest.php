<?php

namespace App\tests\Repository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategoriesRepositoryTest
 *
 * @author hmagn
 */
class CategoriesRepositoryTest extends KernelTestCase {
   /**
     * Recupere le repository de categorie
     * @Return FormationRepository
     */
    public function recupRepository(): CategorieRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    
    public function newCategorie(): Categorie{
        $categorie = (new Categorie())
                ->setName("nouvelle categorie");
        return $categorie;
    }
    
    public function testAddCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategorie = $repository->count([]);
        $repository->add($categorie, true);
        $this->assertEquals($nbCategorie + 1, $repository->count([]), "erreur lors de l'ajout");
        
    }
    
    public function testSupprCategorie(){
        $repository = $this->recupRepository();
        $categorie = $repository->findOneBy(['name' => "nouvelle categorie"]);
        $nbCategorie = $repository->count([]);
        $repository->remove($categorie, true);
        $this->assertEquals($nbCategorie - 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
       public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $categories = $repository->findAllForOnePlaylist(3);
        $nbCategories = count($categories);
        $this->assertEquals(2, $nbCategories);
    }
    
  
    
    
}
