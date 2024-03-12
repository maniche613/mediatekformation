<?php



namespace App\tests\Repository;

use App\Entity\Playlist;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author hmagn
 */
class PlaylistRepositoryTest extends KernelTestCase {
    /**
     * Recupere le repository des playlist
     * @Return FormationRepository
     */
    public function recupRepository():PlaylistRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
    
    public function newPlaylist(): Playlist{
        $playlist = (new Playlist())
                ->setName("nouvelle playlist")
                ->setDescription("nouvelle description");
        return $playlist;
    }
    
    public function testAddPlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylist = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylist + 1, $repository->count([]), "erreur lors de l'ajout");   
    }
    
    public function testSupprPlaylist(){
        $repository = $this->recupRepository();
        $playlist = $repository->findOneBy(['name' => "nouvelle playlist"]);
        $nbPlaylist = $repository->count([]);
        $repository->remove($playlist, true);
        $this->assertEquals($nbPlaylist - 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
     public function testFindAllOrderByName(){
        $repository = $this->recupRepository();
        $playlists = $repository->findAllOrderByName("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(27, $nbPlaylists);
    }
    
     public function testFindAllOrderByNbFormations(){
        $repository = $this->recupRepository();
        $playlists = $repository->findAllOrderByNbFormations("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(27, $nbPlaylists);
    }
    
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $playlists = $repository->findByContainValue("name", "Sujet");
        $nbPlaylists = count($playlists);
        $this->assertEquals(8, $nbPlaylists);
    }
   
}
