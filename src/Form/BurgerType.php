<?php

namespace App\Form;

use App\Entity\Burger;
use App\Entity\Oignon;
use App\Entity\Sauce;
use App\Entity\Pain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BurgerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du burger',
            ])
            ->add('pain' , EntityType::class, [
                'class' => Pain::class,
                'choice_label' => 'nom',
            ])
            ->add('oignon' , EntityType::class, [
                'class' => Oignon::class,
                'choice_label' => 'nom',
                'multiple' => true,
            ])
            ->add('sauce' , EntityType::class, [
                'class' =>  Sauce::class,
                'choice_label' => 'nom',
                'multiple' => true,
            ])
            ->add('image', ImageType::class)
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ])
            ;
   }
    
   public function configureOptions(OptionsResolver $resolver): void
   {
       $resolver->setDefaults([
           'data_class' => Burger::class,
       ]);
   }
}