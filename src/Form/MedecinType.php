<?php

namespace App\Form;

use App\Entity\Cabinet;
use App\Entity\Medecin;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('rpps')
            ->add('telephone')
            ->add('email')
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('cabinets', EntityType::class, [
                'class' => Cabinet::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}
