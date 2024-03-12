<?php

namespace App\tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistsControllerTest
 *
 * @author hmagn
 */
class PlaylistsControllerTest extends WebTestCase{
    
     public function testFiltrePlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Eclipse et Java'
        ]);
        $this->assertCount(1, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Eclipse et Java');
    }
    
    public function testTriPlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/name/DESC');
        $this->assertSelectorTextContains('h5', 'Visual Studio 2019 et C#');
        $client->request('GET', '/playlists/tri/name/ASC');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
    }
    
    
     public function testTriNbFormations(){
        $client = static::createClient();
        $crawler = $client->request('GET', 'playlists/tri/nb_formations/ASC');
        $this->assertSelectorTextContains('th', 'playlist');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Cours Informatique embarquée');
    }
    
     public function testFiltreCategories()
    {
        $client = static::createClient();
        $client->request('GET', '/playlists/recherche/id/categories'); 
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'MCD'
        ]);
        $this->assertCount(5, $crawler->filter('h5'));
         $this->assertSelectorTextContains('h5', 'Cours MCD MLD MPD');
    }
    
    public function testLinkPlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        $client->clickLink("Voir détail");
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get('REQUEST_URI');
        $this->assertEquals('/playlists/playlist/13', $uri);
        $this->assertSelectorTextContains('h4','Bases de la programmation (C#)');
    }
}
