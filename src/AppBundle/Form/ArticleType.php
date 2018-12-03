<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Titre de l\'article',
                'required' => false,
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu de l\'article',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => $options['is_edit'] ? 'Editer !' : 'Ajouter !'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'AppBundle\Entity\Article',
                'is_edit' => false,
            ]);
    }
}
