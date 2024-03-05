<?php

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Controlleur des categories cotés admin
 *
 * @author hmagn
 */
class AdminCategoriesController extends AbstractController{
    
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

    /**
     * Création du constructeur
     * @param CategorieRepository $categorieRepository
     * @param FormationRepository $formationRepository
     */
    function __construct(CategorieRepository $categorieRepository, FormationRepository $formationRepository) {
        $this->categorieRepository= $categorieRepository;
         $this->formationRepository = $formationRepository;
    }
    
    
   /**
    *@Route("/admin/categorie", name="admin.categorie")
    *@return Response
    */
    public function index(): Response
    {
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.categories.html.twig", [
            'categories' => $categories,
            'formations' => $formations 
        ]);
    }
    /**
     * Suppression d'une categorie
     * @Route("/admin/suppr.categorie/{id}", name="admin.categorie.suppr")
     * @param Categorie $categorie
     * @return Response
     */
    public function suppr(Categorie $categorie): Response{
        $this->categorieRepository->remove($categorie, true);
        return $this->redirectToRoute('admin.categorie');
    }
    
    /**
     * Ajout d'une categorie
     * @Route("admin/ajout.categorie", name="admin.categorie.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request):Response{
        $newName = $request->get("newName");
        $nomcategorie = $this->categorieRepository->findAllEqual($newName);

        if ($nomcategorie == false) {
            $categories = new Categorie();
            $categories->setName($newName);
            $this->categorieRepository->add($categories, true);
            return $this->redirectToRoute('admin.categorie');
        }
        return $this->redirectToRoute('admin.categorie');
    }
    
}
