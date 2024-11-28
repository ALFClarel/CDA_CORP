<?php

namespace App\Form;

use App\Entity\Hero;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('isActive')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('leader', EntityType::class, [
                'class' => Hero::class,
                'choice_label' => 'name',
            ])
            ->add('members', EntityType::class, [
                'class' => Hero::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true, // Utilise des cases à cocher pour la sélection multiple
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
