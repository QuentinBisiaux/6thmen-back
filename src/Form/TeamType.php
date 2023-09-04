<?php

namespace App\Form;

use App\Entity\Library\League;
use App\Entity\Library\Team;
use App\Repository\Library\TeamRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function __construct(
        private TeamRepository $teamRepository
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options, ): void
    {
        $builder
            ->add('name')
            ->add('tricode')
            ->add('slug')
            ->add('sisterTeam',EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'choices' => $this->teamRepository->findAllCurentTeams()
            ])
            ->add('league',EntityType::class, [
                'class' => League::class,
                'choice_label' => 'name',
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
