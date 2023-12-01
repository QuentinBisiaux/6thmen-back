<?php

namespace App\Form;

use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\Standing\Entity\Standing;
use App\Domain\Team\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandingType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('league',EntityType::class, [
                'class' => League::class,
                'choice_label' => 'name',
            ])
            ->add('season', EntityType::class, [
                'class' => Season::class,
                'choice_label' => 'year'
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name'
            ])
            ->add('rank')
            ->add('victory')
            ->add('loses')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Standing::class,
        ]);
    }
}
