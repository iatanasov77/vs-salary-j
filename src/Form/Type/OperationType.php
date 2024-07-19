<?php namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use App\Entity\Operation;

class OperationType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            ->add( 'operationId', NumberType::class, [
                'label'                 => 'salary-j.form.number',
                'translation_domain'    => 'SalaryJ',
                'html5'                 => true,
            ])
            
            ->add( 'operationName', TextType::class, [
                'label'                 => 'salary-j.form.name',
                'translation_domain'    => 'SalaryJ',
            ])
            
            ->add( 'minutes', NumberType::class, [
                'label'                 => 'salary-j.form.operations.minutes',
                'translation_domain'    => 'SalaryJ',
                'scale'                 => 2,
            ])
            
            ->add( 'workCount', CollectionType::class, [
                'allow_add'             => true,
                'allow_extra_fields'    => true,
                'entry_type'            => OperatorWorkType::class,
                'entry_options'         => ['label' => false],
                'mapped'                => false,
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        //parent::configureOptions( $resolver );
        $resolver->setDefaults([
            'data_class'            => Operation::class,
            'allow_extra_fields'    => true,
        ]);
    }
}
