<?php namespace App\Form;

use VS\ApplicationBundle\Form\AbstractForm;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use VS\ApplicationBundle\Component\I18N;

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
            
            
            ->add( 'operationId', TextType::class, [
                'label'                 => 'salary-j.form.number',
                'translation_domain'    => 'SalaryJ',
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
            
            ->add( 'price', HiddenType::class )
        ;
    }
}
