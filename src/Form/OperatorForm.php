<?php namespace App\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use App\Form\Type\OperatorType;
use App\Entity\Operator;
use App\Entity\OperatorsGroup;

class OperatorForm extends AbstractForm
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        parent::buildForm( $builder, $options );
        
        $builder
            ->add( 'application_code', HiddenType::class, ['mapped' => false] )
        
            ->add( 'operator', OperatorType::class, [
                'mapped'        => false,
                'data_class'    => Operator::class,
            ])
        ;
    }
    
    public function getName()
    {
        return 'salary_j.operator';
    }
}
