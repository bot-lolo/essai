<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Repository\ClasseRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            /**->add(
                $builder->create('classe', ClasseType::class, ['nom' => ])
            )*/
            ->add('classe',ClasseType::class,[
                'nom'=>Classe::class,
                'query_builder'=>function(ClasseRepository $c){
                    return $c->createQueryBuilder('u')
                    ->orderBy('u.nom','ASC');
                },
                'choice_label'=>'classe',

            
            ]
            )
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
        //$resolver->setAllowedTypes('require_due_date', 'bool');
    }
}
