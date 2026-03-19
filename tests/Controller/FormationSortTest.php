<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of FormationSortTest
 *
 * @author erwme
 */
class FormationSortTest extends WebTestCase{
     
    public function testSortByName(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations');
        
        // Vérifier que le tableau existe 
        $this->assertSelectorExists('table');
        
        // Récupère le premier bouton de tri dans le colonne "formation"
        $linkNode = $crawler->filter('th:first-child a')->first();
        
        $this->assertGreaterThan(
                0,
                $linkNode->count(),
                'Aucun bouton de tri trouvé dans la première colonne.'
        );
        
        // Cliquer sur le lien 
        $crawler = $client->click($linkNode->link());
        
        // Vérifier qu'il y a au moins une ligne dans le tableau 
        $row = $crawler->filter('table tbody tr');
        $this->assertGreaterThan(0, $row->count(), 'Aucune ligne trouvée après tri.');
        
        // Vérifier la premièe cellule 
        $firstCell = $row->first()->filter('td')->first()->text();
        $this->assertNotEmpty($firstCell);
        
    }
}
