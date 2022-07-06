<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Repository\ClasseRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EtudiantFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //ClasseRepository $e;
        $builder
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            /**->add(
                $builder->create('classe', ClasseType::class, ['nom' => ])
            )*/
            /**->add('classe', ChoiceType::class,[
                'choices'=>$nom,
                'multiple'=>true,
            ])*/
            /**->add('classe', ChoiceType::class, [
                'class' => ClasseType::class,
                'choices' => function(ClasseRepository $er) {
                    return $er->name();
                        //->where('u.roles LIKE :roles')
                        //->setParameter('roles', '%"ROLE_SUPER_ADMIN"%');
                },
                'multiple'=>true,
    ])*/
            ->add(
                $builder->add('classe', Classe::class,[
                    'class'=>Classe::class,
                    'choice_label'=>'translation[en].nom',
                ])
            )
            /**->add('classe',ClasseType::class,[
                'nom'=>Classe::class,
                'query_builder'=>function(ClasseRepository $er){
                    return $er->name();
                },
                'choice_label'=>'nom',
            ]
            )*/
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
