<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author erwme
 */
class FormationTest extends TestCase {
   
    public function testGetDatecreationString(){
        $formation = new Formation();
        $formation->setPublishedAt(new DateTime("2026-03-09"));
        $this->assertEquals("09/03/2026", $formation->getPublishedAtString());
    }
}
