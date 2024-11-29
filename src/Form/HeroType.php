<?php

namespace App\Form;

use App\Entity\Hero;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class HeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'label' => 'Nom du Héro: ',
                'label_attr' => [
                    'class' => 'block mb-2 text-indigo-500', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300', 
                    'placeholder' => 'Entrez le nom du héro',
                ],
            ])
            ->add('alterEgo',TextType::class, [
                'label' => 'AlterEgo: ',
                'label_attr' => [
                    'class' => 'block mb-2 text-indigo-500', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300', 
                    'placeholder' => 'Entrez le nom utilisé de héro',
                ],
            ])
            ->add('equipment',TextType::class, [
                'label' => 'Équipement: ',
                'label_attr' => [
                    'class' => 'block mb-2 text-indigo-500', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300', 
                    'placeholder' => 'Entrez les équipements',
                ],
            ])
            ->add('Available',ChoiceType::class, [
                'choices' => [
                        'Oui' => 1,
                        'Non' => 0,
                    ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Disponible',
                'label_attr' => [
                    'class' => 'block mb-2 text-indigo-500', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300',
                ],
                'choice_attr' => [
                    'Oui' => ['class' => 'ml-3 mr-1'], 
                    'Non' => ['class' => 'ml-3 mr-1'], 
                ],
            ])
            ->add('energyLevel', IntegerType::class, [
                'label' => 'Niveau d\'énergie',
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'required' => true,
                'constraints' => [
                    new Assert\Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' => 'Le niveau d\'énergie doit être compris entre {{ min }} et {{ max }}.',
                    ]),
                ],
                'label_attr' => [
                    'class' => 'block mb-2 text-indigo-500', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300',
                ],
            ])
            ->add('biography',TextType::class,[
                'label' => 'Biographie: ',
                'label_attr' => [
                    'class' => 'block mb-2 text-indigo-500', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300', 
                    'placeholder' => 'Entrez le pseudo du héro',
                ],
            ])
            ->add('image_name', FileType::class, [
                'label' => 'Image: ',
                'label_attr' => [
                    'class' => 'text-indigo-700'
                ],
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez entrer un fichier valide',
                    ])
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300',
                ],
            ])
            ->add('pseudo',TextType::class, [
                'label' => 'Pseudo: ',
                'label_attr' => [
                    'class' => 'block mb-2 text-indigo-500', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300', 
                    'placeholder' => 'Entrez le pseudo du héro',
                ],
            ])
            ->add('password',PasswordType::class, [
                'label' => 'Mot de passe : ',
                'label_attr' => [
                    'class' => 'block mb-2 text-indigo-500', 
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300', 
                    'placeholder' => 'Entrez le mot de passe du héro',
                ],
            ])
            // ...
        
            ->add('createdAt', null, [
                'widget' => 'single_text',
                'label' => 'Date de création : ',
                'label_attr' => [
                    'class' => 'block mb-2 text-indigo-500',
                ],
                'attr' => [
                    'class' => 'w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300',
                    'placeholder' => 'Entrez la date de création',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hero::class,
        ]);
    }
}
