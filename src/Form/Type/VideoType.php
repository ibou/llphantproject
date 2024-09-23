<?php

declare(strict_types=1);

namespace App\Form\Type;
 
use App\Enum\VideoDescriptionSize;
use App\Form\Model\VideoModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                'attr' => [
                    'placeholder' => 'Sujet de la vidéo',
                ],
                'label' => 'Sujet de la vidéo',
            ])
            ->add('descriptionSize', EnumType::class, [
                'class' => VideoDescriptionSize::class,
                'label' => 'Taille de la description',
            ])
            ->add('numberOfTags', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Nombre de tags',
                    'min' => 1,
                    'max' => 10,
                ],
                'data' => 1,
                'html5' => true,
                'label' => 'Nombre de tags',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer la vidéo',
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VideoModel::class,
        ]);
    }
}
