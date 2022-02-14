<?php namespace App\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Vankosoft\ApplicationBundle\Component\I18N;
use App\Form\Type\OperationType;
use App\Entity\Operation;

class OperationForm extends AbstractForm
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        parent::buildForm( $builder, $options );
        
        $operation  = isset( $options['data'] ) ? $options['data'] : null;
        $builder
            ->setMethod( $operation && $operation->getId() ? 'PUT' : 'POST' )
            
            ->add( 'application_code', HiddenType::class, ['mapped' => false] )
            
            ->add( 'currentLocale', ChoiceType::class, [
                'label'                 => 'salary-j.form.locale',
                'translation_domain'    => 'SalaryJ',
                'choices'               => \array_flip( I18N::LanguagesAvailable() ),
                'mapped'                => false,
            ])
            
            ->add( 'price', HiddenType::class )
            
            ->add( 'operation', OperationType::class, [
                'mapped'        => false,
                'data_class'    => Operation::class,
            ])
        ;
    }
}
