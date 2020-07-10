<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\SiteTouristique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')

            ->add('author')
            
            ->add('users', EntityType::class,[
                'class' => User::class,
                'choice_label' => 'userlastname'
            ])
            
            ->add('siteTouristiques', EntityType::class,[
                'class' => SiteTouristique::class,
                'choice_label' => 'title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
