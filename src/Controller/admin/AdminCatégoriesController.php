<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


/**
 * Description of AdminCatégoriesController
 *
 * @author erwme
 */
class AdminCatégoriesController extends AbstractController{
  
  /**
   * 
   * @var type
   */
  private $repository;
  
  /**
   * 
   * @param CategorieRepository $repository
   */
  public function __construct(CategorieRepository $repository){
      $this->repository = $repository;
  }
  
  #[Route('/admin/categories', name: 'admin.categories')]
  public function index(): Response{
      $categories = $this->repository->findall();
      return $this->render("admin/admin.categories.html.twig", [
          'categories' => $categories
      ]);
  }
  
  #[Route('/admin/categorie/suppr/{id}', name: 'admin.categorie.suppr')]
  public function suppr(int $id): Response{
      $categorie = $this->repository->find($id);
      
      if(!$categorie){
      return $this->redirectToRoute('admin.categories');
      }
      
      // Vérification : la catégorie est elle liée à des formations ?
      if($categorie->getFormations()->count() > 0){
      $this->addFlash("error", "Impossible de supprimer une catégorie liée à des formations.");
      return $this->redirectToRoute('admin.categories');
      }
      
      // Suppression autorisée
      $this->repository->remove($categorie);
      return $this->redirectToRoute('admin.categories');
  }
  
  #[Route('/admin/categorie/ajout', name: 'admin.categorie.ajout')]
  public function ajout(Request $request): Response{
      $nomCategorie = trim($request->get("nom"));
      
      // vérifie si vide
      if($nomCategorie === ""){
          $this->addFlash("error", "Le nom de la catégorie ne peut pas être vide.");
          return $this->redirectToRoute('admin.categories');
      }
      
      // vérifie si la catégorie existe déjà 
      $existe = $this->repository->findOneBy(['name' => $nomCategorie]);
      if($existe){
          $this->addFlash("error", "Cette catégorie existe déjà.");
           return $this->redirectToRoute('admin.categories');
      }
      
      // Ajout autorisé 
      $categorie = new Categorie();
      $categorie->setName($nomCategorie);
      $this->repository->add($categorie);
      return $this->redirectToRoute('admin.categories');
  }
    
}
