<?php

namespace App\Form;

use App\Entity\MasterOfDestiny;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class MasterOfDestinyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom: ',
                'label_attr' => [
                    'class' => 'block mb-2 text-amber-600', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-amber-600 outline-none focus:bg-gray-300', 
                    'placeholder' => 'Entrez le nom du maître',
                ],
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo: ',
                'label_attr' => [
                    'class' => 'block mb-2 text-amber-600', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-amber-600 outline-none focus:bg-gray-300', 
                    'placeholder' => 'Entrez le pseudo de connexion',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe: ',
                'label_attr' => [
                    'class' => 'block mb-2 text-amber-600', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-amber-600 border-b-2 border-amber-600 outline-none focus:bg-gray-300', 
                    'placeholder' => 'Entrez le mot de passe',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MasterOfDestiny::class,
        ]);
    }
}
