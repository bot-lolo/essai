<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;
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
    #[Route('/etudiant/{id}', name: 'shoh_etudiant')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $etudiant = $doctrine->getRepository(Etudiant::class)->find($id);

        if (!$etudiant) {
            throw $this->createNotFoundException(
                'Non trouver '.$id
            );
        }

        return new Response('Check out this great product: '.$etudiant->getNom());
    }
    #[Route('/etudiant/new', name: 'new_etudiant')]
    public function new(): Response
    {
        $etudiant=new Etudiant();
        $form=$this->createForm(EtudiantFormType::class, $etudiant);

        return $this->renderForm('etudiant/add.html.twig',[
            'form'=>$form,
        ]);
    }

    

}
