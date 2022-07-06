<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantFormType;
use App\Form\SubmitType;
use App\Repository\EtudiantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }
    #[Route('/etudiant/number/{max}', name: 'number_etudiant')]
    public function number(int $max): Response
    {
        $number = random_int(0, $max);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
    
    #[Route('/etudiant/new', name: 'new_etudiant')]
    public function new(Request $request,ManagerRegistry $doctrine): Response
    {
        $etudiant=new Etudiant();
        $form=$this->createForm(EtudiantFormType::class, $etudiant);
        $form->handleRequest($request);



        if($form->isSubmitted()&& $form->isValid()){
            $entityManager = $doctrine->getManager();
            $nom=$etudiant->getNom();
            $prenom=$etudiant->getPrenom();
            $classe=$etudiant->getClasse();
            $etudiant->setNom($nom);
            $etudiant->setPrenom($prenom);
            $etudiant->setClasse($classe);
            
            $entityManager->persist($etudiant);
            
            $entityManager->flush();
            return $this->redirectToRoute('etudiant_success');
        }
        return $this->renderForm('etudiant/add.html.twig',[
            'form'=>$form,
        ]);
    }

    #[Route('/etudiant/etudiant_success', name: 'etudiant_success')]
    public function good(EtudiantRepository $etudiantRepository): Response
    {
        

        return $this->renderForm('etudiant/aff.html.twig',[
            'controller_name' => 'EtudiantController',
            'etudiant'=>$etudiantRepository->findAll(),
        ]);
    }

    

}
