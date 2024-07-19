<?php namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\OperatorsGroup;
use App\Entity\Operator;

class OperatorWorkOperatorType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            //->add( 'id', HiddenType::class, ['mapped' => true] )
        
            ->add( 'operations', CollectionType::class, [
                'allow_add'             => true,
                'allow_extra_fields'    => true,
                'entry_type'            => OperationType::class,
                'entry_options'         => ['label' => false],
                'mapped'                => false,
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        //parent::configureOptions( $resolver );
        $resolver->setDefaults([
            'data_class'            => null,
            'allow_extra_fields'    => true,
        ]);
    }
}
