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
    public function index(EtudiantRepository $doctrine): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
            'etudiants'=>$doctrine->findAll(),
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
    public function new(Request $request,EtudiantRepository $doctrine): Response
    {
        $etudiant=new Etudiant();
        $form=$this->createForm(EtudiantFormType::class, $etudiant);
        $form->handleRequest($request);



        if($form->isSubmitted()&& $form->isValid()){
            //dd($etudiant);
            //$entityManager = $doctrine->getManager();
            $doctrine->add($etudiant,true);
            return $this->renderForm('etudiant/index.html.twig',[
                'etudiants'=>$doctrine->findAll(),
            ]);
        }
        return $this->renderForm('etudiant/add.html.twig',[
            'form'=>$form,
        ]);
    }

    #[Route('/etudiant/{id}}', name: 'delete_success')]
    public function suppression(EtudiantRepository $etudiantRepository,int $id): Response
    {
        $etudiant=new Etudiant();
        $etudiant=$etudiantRepository->find($id);
        $etudiantRepository->remove($etudiant,true);

        return $this->render('etudiant/index.html.twig');
    }

    

}
