<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Repository\PlaylistRepository; 
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author erwme
 */
class PlaylistRepositoryTest extends KernelTestCase{
    
    public function recupRepository(): PlaylistRepository{
        self::bootKernel();
        return self::getContainer()->get(PlaylistRepository::class);
    }
   
    public function testFindOrder(){
    $repository = $this->recupRepository();
    $playlists = $repository->findOrder('ASC');

    // Vérifie que la méthode renvoie bien un tableau
    $this->assertIsArray($playlists);

    // Vérifie que le tableau n'est pas vide
    $this->assertNotEmpty($playlists);

    // Vérifie que chaque élément est bien une Playlist
    foreach ($playlists as $playlist) {
        $this->assertInstanceOf(\App\Entity\Playlist::class, $playlist);
    }
}


}
