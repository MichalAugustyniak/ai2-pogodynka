<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                'label' => 'Select date',
            ])
            ->add('max_celsius')
            ->add('min_celsius')
            ->add('pressure_hpa')
            ->add('wind_speed_kmh')
            ->add('wind_direction', ChoiceType::class, [
                'choices' => [
                    'North' => 'N',
                    'North-east' => 'NE',
                    'North-west' => 'NW',
                    'West' => 'W',
                    'South-west' => 'SW',
                    'South' => 'S',
                    'South-east' => 'SE',
                    'East' => 'E',
                ]
            ])
            ->add('humidity_percent')
            ->add('location', EntityType::class, [
                'class' => Location::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
