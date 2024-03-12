<?php

namespace App\Tests\Validations;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationsValidationsTest
 *
 * @author hmagn
 */
class FormationsValidationsTest extends KernelTestCase {
    
    public function getFormation(): Formation{
        return (new Formation())
        ->setTitle('Formation Test'); 
    }
    
    public function assertErrors(Formation $formation, int $nbErreurAttendus, string $message="")
    {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertcount($nbErreurAttendus, $error, $message);
    }
    
    public function testValidDateFormations()
    {
        $formations = $this->getFormation()->setPublishedAt(new \DateTime("2024-12-12"));
        $this->assertErrors($formations,1, "la date devrait echouer");
                
    }
}
