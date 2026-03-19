<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Formation;
use App\Entity\Playlist;
use App\Form\FormationType;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminPlaylistsController
 *
 * @author erwme
 */
class AdminPlaylistsController extends AbstractController {
  
    private const PAGESPLAYLISTS = "admin/admin.Playlists.html.twig";
    private const PAGESPLAYLIST = "admin/admin.Playlist.html.twig";
    /**
     * 
     * @var PlaylistRepository
     */
    private $playlistRepository;
    
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;    
    
    function __construct(PlaylistRepository $playlistRepository, 
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
    /**
     * @Route("/playlists", name="playlists")
     * @return Response
     */
    #[Route('/admin/playlists', name: 'admin.playlists')]
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGESPLAYLISTS , [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }

    #[Route('/admin/playlists/tri/{champ}/{ordre}', name: 'admin.playlists.sort')]
    public function sort($champ, $ordre): Response{
        switch($champ){
            case "name":
                $playlists = $this->playlistRepository->findAllOrderByName($ordre);
                break;
            case "tri":
                $playlists = $this->playlistRepository->findOrder($ordre);
                break;
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGESPLAYLISTS , [
            'playlists' => $playlists,
            'categories' => $categories,            
        ]);
    }          

    #[Route('/admin/playlists/recherche/{champ}/{table}', name: 'admin.playlists.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGESPLAYLISTS , [
            'playlists' => $playlists,
            'categories' => $categories,            
            'valeur' => $valeur,
            'table' => $table
        ]);
    }  

    #[Route('/admin/playlists/playlist/{id}', name: 'admin.playlists.showone')]
    public function showOne($id): Response{
        $playlist = $this->playlistRepository->find($id);
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render(self:: PAGESPLAYLIST , [
            'playlist' => $playlist,
            'playlistcategories' => $playlistCategories,
            'playlistformations' => $playlistFormations
        ]);        
    }  
    
     #[Route('/admin/playlist/suppr/{id}', name: 'admin.playlist.suppr')]
    public function suppr(int $id):Response{
        $playlist = $this->playlistRepository->find($id);
        
        // Vérifie si la playlist contient des formations
        if(count($playlist->getFormations()) > 0){
        $this->addFlash('error', 'Impossible de supprimer cette playlist : des formations y sont rattachées.');
        return $this->redirectToRoute('admin.formations');
        }
        $this->playlistRepository->remove($playlist);
        $this->addFlash('success','Playlist supprimée avec succès.');
        return $this->redirectToRoute('admin.formations');
    }
    
    #[Route('/admin/playlist/modifier/{id}', name: 'admin.playlist.modifier')]
    public function modify(int $id, Request $request): Response{
        $playlist = $this->playlistRepository->find($id);
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        
        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute('admin.formations');
        }
        return $this->render("admin/admin.Playlist.Modifier.html.twig", [
            'playlist' => $playlist,
            'playlistformations' => $playlistFormations,
            'playlistcategories' => $playlistCategories,
            'formPlaylist' => $formPlaylist->createView()
        ]);
    }
    
    #[Route('/admin/playlist/ajout', name: 'admin.playlist.ajout')]
    public function ajout(Request $request): Response{
        $playlist = new Playlist();
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        
        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute('admin.formations');
        }
        return $this->render("admin/admin.Playlist.ajout.html.twig", [
            'playlist' => $playlist,
            'formPlaylist' => $formPlaylist->createView()
        ]);
    }
    
}
