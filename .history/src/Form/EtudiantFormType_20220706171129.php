<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('classe', EntityType::class,[
                'class'=>Classe::class,
                'choice_label'=>'id',
                'label'=>'classe',])

            /**->add('nom', EntityType::class, [
                'class' => Classe::class,
                'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
            ->orderBy('u.nom', 'ASC');
            },
            'choice_label' => 'classe',
            ])*/
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
