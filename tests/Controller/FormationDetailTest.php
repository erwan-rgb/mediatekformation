<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of FormationDetailTest
 *
 * @author erwme
 */
class FormationDetailTest extends WebTestCase{
    
    public function testClickOnFormationOpensDetailPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations');
        
         // Vérifier que le tableau existe
        $this->assertSelectorExists('table');

        // Récupérer le titre de la première formation dans la liste
        $firstTitle = $crawler->filter('table tbody tr:first-child td:first-child h5')->text();

        // Récupérer le lien vers la page détail (vidéo ou miniature)
        $linkNode = $crawler->filter('table tbody tr:first-child td:last-child a')->first();
        $this->assertGreaterThan(
            0,
            $linkNode->count(),
            'Aucun lien vers la page détail trouvé.'
        );

        // Cliquer sur le lien
        $crawler = $client->click($linkNode->link());

        // Vérifier que la page est accessible
        $this->assertResponseIsSuccessful();

        // Vérifier que le titre apparaît dans la page détail (dans le <h4>)
        $this->assertSelectorTextContains('h4.text-info', $firstTitle);

    }
}
