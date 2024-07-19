<?php namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\OperatorsWork;

class OperatorWorkType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            ->add( 'workCount', TextType::class, ['mapped' => false] )
            ->add( 'workId', HiddenType::class, ['mapped' => false] )
            ->add( 'workCountOld', HiddenType::class, ['mapped' => false] )
            ->add( 'price', HiddenType::class, ['mapped' => false] )
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        //parent::configureOptions( $resolver );
        $resolver->setDefaults([
            //'data_class'            => OperatorsWork::class,
            'data_class'            => null,
            'allow_extra_fields'    => true,
        ]);
    }
}