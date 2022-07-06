<?php

namespace App\Controller;

use App\Entity\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
    #[Route('/search/chercher', name: 'search_etud')]
    public function search(Request $request): Response
    {
        $search=new Search();
        $form=$this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){

            $search=$form->getData();
            //$etudiantRepository->search($search,true);
            return $this->renderForm('etudiant/index.html.twig',[
                //'etudiants'=>$etudiantRepository->findAll(),
                'controller_name' => 'EtudiantController',
                //'conter'=>$etudiantRepository->cont(),
            ]);
            //return $this->redirectToRoute('app_etudiant');
        }
        return $this->renderForm('search/chercher.html.twig',[
            'form'=>$form,
        ]);
    }
}
