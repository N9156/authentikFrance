<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\SiteTouristique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SiteTouristiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('image')
            ->add('adress')
            ->add('phone')
            ->add('mail')
            ->add('contactProfessionnel')
            ->add('url')
            ->add('publication')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title'
            ])
            
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'userlastname'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SiteTouristique::class,
        ]);
    }
}
