<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of FormationFilterTest
 *
 * @author erwme
 */
class FormationFilterTest extends WebTestCase{
    
    public function testFilterByTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations');

        // Vérifier que le tableau existe
        $this->assertSelectorExists('table');

        // Récupérer le formulaire de filtre dans la première colonne
        $form = $crawler->filter('th:first-child form')->form([
            'recherche' => 'Java'
        ]);
        
         // Soumettre le formulaire
        $crawler = $client->submit($form);

        // Vérifier qu'il y a au moins une ligne dans le tableau filtré
        $rows = $crawler->filter('table tbody tr');
        $this->assertGreaterThan(0, $rows->count(), 'Aucun résultat après filtrage.');

        // Vérifier que la première cellule contient bien le mot filtré
        $firstCell = $rows->first()->filter('td')->first()->text();
        $this->assertStringContainsString('Java', $firstCell);
    
    }
}
