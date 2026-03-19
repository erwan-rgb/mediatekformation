<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Formation;
use App\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;

/**
 * Description of FormationValidationsTest
 *
 * @author erwme
 */
class FormationValidationsTest extends KernelTestCase{
    
    public function testValidPublishedAt(){
       self::bootKernel();
       $validator = static::getContainer()->get('validator');
       
       //playlist valide
       $playlist = new Playlist();
       $playlist->setName("Test playlist");
       
       // Formation avec date future 
       $formation = new Formation();
       $formation->setPublishedAt(new DateTime('+2 days')); 
       $formation->setTitle("Test");
       $formation->setPlaylist($playlist);
       
       $errors = $validator->validate($formation);
       
       $this->assertGreaterThan(
               0, 
               count($errors),
               "La validation devrait échouer car la date est dans le futur."
       );
    }
    
    
}
