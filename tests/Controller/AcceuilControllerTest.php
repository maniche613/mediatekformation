<?php

namespace App\tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Test du controleur de l'accueil
 *
 * @author hmagn
 */
class AcceuilControllerTest extends WebTestCase {
    
    public function testAccesPage(){
       $client = static::createClient();
       $client->request('GET', '/');
       $this->assertResponseStatusCodeSame(Response::HTTP_OK);
   }
    
}
