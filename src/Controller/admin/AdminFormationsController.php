<?php

namespace App\Controller\admin;

use App\Entity\Formation;
use App\Form\FormationsType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Controlleur dess formations cotés admin
 *
 * @author hmagn
 */
class AdminFormationsController extends AbstractController {
      

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
    
    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository)
    {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository= $categorieRepository;
    }
    
    /**
     * @Route("/admin", name="admin.formations")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.formations.html.twig", [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }
    
    /**
     * Suppression d'une formation
     * @Route("/admin/suppr.formation/{id}", name="admin.formation.suppr")
     * @param Formation $formations
     * @return Response
     */
    public function suppr(Formation $formations): Response{
        $this->formationRepository->remove($formations, true);
        return $this->redirectToRoute('admin.formations');
    }
    
    /**
     * Edition d'une formation
     * @Route("/admin/edit/{id}", name="admin.edit.formations")
     * @param Formation $formations
     * @param Request $request
     * @return Response
     */
    public function edit(Formation $formations, Request $request):Response{
        $formFormation = $this->createForm(FormationsType::class, $formations);
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formations, true);
            return $this->redirectToRoute('admin.formations');
        }
        
        return $this->render("admin/admin.formation.edit.html.twig", [
            'formation' => $formations,
            'formFormation' => $formFormation->createView()
        ]);
    }
    
    /**
     * Ajout d'une formation
     * @Route("admin/ajout", name="admin.ajout.formations")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request):Response{
        $formations = new Formation();
        $formFormation = $this->createForm(FormationsType::class, $formations);
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formations, true);
            return $this->redirectToRoute('admin.formations');
        }
        
        return $this->render("admin/admin.formation.ajout.html.twig", [
            'formation' => $formations,
            'formFormation' => $formFormation->createView()
        ]);
    }
    
       /**
     * @Route("/admin/formations/tri/{champ}/{ordre}/{table}", name="admin.formations.sort")
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Response
     */
    public function sort($champ, $ordre, $table=""): Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.formations.html.twig", [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }     
    
    /**
     * @Route("/admin/formations/recherche/{champ}/{table}", name="admin.formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.formations.html.twig", [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    } 
}
