<?php

namespace App\Controller\admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminPlaylistController
 *
 * @author hmagn
 */
class AdminPlaylistController extends AbstractController{
    
     /**
         * @var PlaylistRepository
         */
        private $playlistRepository;

        /**
         * @var FormationRepository
         */
        private $formationRepository;

        /**
         * @var CategorieRepository
         */
        private $categorieRepository;
        
        
        /**
        * Création du constructeur
        * @param PlaylistRepository $playlistRepository
        * @param FormationRepository $formationRespository
        * @param CategorieRepository $categorieRepository
        */
        public function __construct(PlaylistRepository $playlistRepository, CategorieRepository $categorieRepository, FormationRepository $formationRespository)
        {
            $this->playlistRepository = $playlistRepository;
            $this->categorieRepository = $categorieRepository;
            $this->formationRepository = $formationRespository;
        }

       /**
        * @Route("/admin.playlists", name="admin.playlist")
        * @return Response
        */
        public function index(): Response
        {
            $playlists = $this->playlistRepository->findAllOrderByName('ASC');

            $categories = $this->categorieRepository->findAll();
            return $this->render("admin/admin.playlists.html.twig", [
                'playlists' => $playlists,
                'categories' => $categories
            ]);
        }
        
    /**
     * Suppression d'une playlist
     * @Route("/admin/suppr.playlist/{id}", name="admin.playlist.suppr")
     * @param Playlist $playlist
     * @return Response
     */
    public function suppr(Playlist $playlist): Response{
        $this->playlistRepository->remove($playlist, true);
        return $this->redirectToRoute('admin.playlist');
    }
    
    /**
     * Edition d'une playlist
     * @Route("/admin/edit.playlists/{id}", name="admin.playlist.edit")
     * @param Playlist $playlist
     * @param Request $request
     * @return Response
     */
    public function edit(Playlist $playlist, Request $request):Response{
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        
        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist, true);
            return $this->redirectToRoute('admin.playlist');
        }
        
        return $this->render("admin/admin.playlist.edit.html.twig", [
            'playlist' => $playlist,
            'formPlaylist' => $formPlaylist->createView()
        ]);
    }
    
    /**
     * Ajout d'une playlist
     * @Route("admin/ajout.playlist", name="admin.ajout.playlists")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request):Response{
        $playlist = new Playlist();
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        
        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist, true);
            return $this->redirectToRoute('admin.playlist');
        }
        
        return $this->render("admin/admin.playlist.ajout.html.twig", [
            'playlists' => $playlist,
            'formPlaylist' => $formPlaylist->createView()
        ]);
    }
    
  
        /**
         * Tri des enregistrements
         * @Route("/admin/playlists/tri/{champ}/{ordre}", name="admin.playlists.sort")
         * @param type $champ
         * @param type $ordre
         * @return Response
         */
        public function sort($champ, $ordre): Response
        {
            switch ($champ) {
                case "name":
                    $playlists = $this->playlistRepository->findAllOrderByName($ordre);
                    break;
                case "nb_formations":
                    $playlists = $this->playlistRepository->findAllOrderByNbFormations($ordre);
                    break;
                default:
                    // Gérer le cas par défaut ou afficher une erreur selon vos besoins
                    throw new \InvalidArgumentException("Champ de tri non pris en charge: $champ");
            }

            $categories = $this->categorieRepository->findAll();

            return $this->render("admin/admin.playlists.html.twig", [
                'playlists' => $playlists,
                'categories' => $categories
            ]);
        }



        /**
         * Tri des enregistrements selon le nom des playlists
         * @Route("/admin/playlists/recherche/{champ}/{table}", name="admin.playlists.findallcontain")
         * @param type $champ
         * @param Request $request
         * @param type $table
         * @return Response
         */
        public function findAllContain($champ, Request $request, $table=""): Response
        {
            $valeur = $request->get("recherche");
            $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
            $categories = $this->categorieRepository->findAll();
            return $this->render("admin/admin.playlists.html.twig", [
                'playlists' => $playlists,
                'categories' => $categories,
                'valeur' => $valeur,
                'table' => $table
            ]);
        }  
    
    
}
