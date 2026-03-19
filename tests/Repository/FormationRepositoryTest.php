<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author erwme
 */
class FormationRepositoryTest extends KernelTestCase{
    
    public function recupRepository(): FormationRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    public function testNbFormation(){
        $repository = $this->recupRepository();
        $nbFormations = $repository->count([]);
        $this->assertEquals(238, $nbFormations);
    }
    
     public function testFindByContainValue(){
  
    $repo = $this->recupRepository();

    $formations = $repo->findByContainValue('title', 'Java');

    $this->assertNotEmpty($formations);
    $this->assertStringContainsStringIgnoringCase('Java', $formations[0]->getTitle());
   }

    
}
