<?php


namespace App\Tests;

use App\Entity\Formation;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationsTest
 *
 * @author hmagn
 */
class FormationsTest extends TestCase{
    
    public function testGetPublishedAtString(){
        $formations = new Formation();
        $formations->setPublishedAt(new \DateTime("2021-01-04"));
        $this->assertEquals("04/01/2021", $formations->getPublishedAtString());
    }
}
