<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantFormType;
use App\Controller\EeeType;
use App\Form\SubmitType;
use App\Controller\redirectToRoute;
use App\Repository\EtudiantRepository;
use App\Controller\EtuNomFormType;
use Doctrine\ORM\Mapping\Id;
use App\Controller\Post;
use App\Entity\Search;
use App\Form\SearchType;
use Doctrine\DBAL\Types\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Form\Extension\Core\Type\SubmitType as TypeSubmitType;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(EtudiantRepository $doctrine): Response
    {
        $nombredetudiant=$doctrine->cont();
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
            'etudiants'=>$doctrine->findAll(),
            'conter'=>$nombredetudiant,
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
                'conter'=>$doctrine->cont(),
            ]);
        }
        return $this->renderForm('etudiant/add.html.twig',[
            'form'=>$form,
        ]);
    }

    #[Route('/{etudiant}', name: 'delete_success')]
    public function delete(Etudiant $etudiant,EtudiantRepository $etudiantRepository): Response
    {
        //$repository = $entityManager->getRepository(Etudiant::class);
        //$etudiant=new Etudiant();
        //$etudiant=$etudiantRepository->findOneBy(['id'=>$id]);
        $etudiantRepository->remove($etudiant,true);

        return $this->redirectToRoute('app_etudiant');
    }
    #[Route('/{etudiant}/edit', name: 'edit_success')]
    //ParamConverter("post", options={"id" = "post_id"})
    public function edit(Request $request,EtudiantRepository $etudiantRepository,Etudiant $etudiant): Response
    {
        //$etudiant=$etudiantRepository->findOneBy(['id'=>$id]);
        $form=$this->createForm(EtudiantFormType::class, $etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $etudiantRepository->edit($etudiant,true);
            return $this->renderForm('etudiant/index.html.twig',[
                'etudiants'=>$etudiantRepository->findAll(),
                'conter'=>$etudiantRepository->cont(),
            ]);
        }
        return $this->renderForm('etudiant/add.html.twig',[
            'form'=>$form,
        ]);
        
    }


    #[Route('etudiant/search', name: 'search_etudiant')]
    public function search(Request $request,EtudiantRepository $etudiantRepository): Response
    {
        $search=new Search();
        $form=$this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){

            $search=$form->getData();
            $etudiantRepository->search($search,true);
            /**return $this->renderForm('etudiant/index.html.twig',[
                'etudiants'=>$etudiantRepository->findAll(),
                'conter'=>$etudiantRepository->cont(),
            ]);*/
            return $this->redirectToRoute('app_etudiant');
        }
        return $this->renderForm('etudiant/search.html.twig',[
            'form'=>$form,
        ]);
    }
    #[Route('etudiant/chercher', name: 'chercher_etudiant')]
    public function trouver(Request $request,EtudiantRepository $doctrine): Response
    {
        $etudiant=new Etudiant();
        $form=$this->createFormBuilder($etudiant)
            ->add('nom',TextType::class)
            ->add('save',TypeSubmitType::class,['label'=>'Recherche'])
            ->getForm();
        $form->handleRequest($request);



        if($form->isSubmitted()&& $form->isValid()){
            //dd($etudiant);
            //$entityManager = $doctrine->getManager();
            $doctrine->search($etudiant,true);
            return $this->renderForm('etudiant/aff.html.twig',[
                //'etudiants'=>$doctrine->findAll(),
                //'conter'=>$doctrine->cont(),
            ]);
        }
        return $this->renderForm('etudiant/search.html.twig',[
            'form'=>$form,
        ]);
    }
    

}
