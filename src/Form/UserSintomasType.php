<?php

namespace App\Form;

use App\Entity\UserSintomas;
use App\Entity\Sintoma;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\SintomaRepository;

class UserSintomasType extends AbstractType
{
    private $sintomasRepository;

    public function __construct(SintomaRepository $sintomasRepository)
    {
        $this->sintomasRepository = $sintomasRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', DateType::class)
            ->add('descripcion')
            ->add('sintoma', EntityType::class, [
                'class' => Sintoma::class,
                'choices' => $this->sintomasRepository->findAll(),
                'choice_label' => 'descripcion'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSintomas::class,
        ]);
    }
}
