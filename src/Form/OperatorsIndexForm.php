<?php namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use App\Form\Type\OperatorType;
use App\Entity\Operator;

class OperatorsIndexForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder->add( 'operators', CollectionType::class, [
            'mapped'        => false,
            'data_class'    => Operator::class,
            'entry_type'    => OperatorType::class,
            'entry_options' => ['label' => false],
        ]);
    }
    
    public function getName()
    {
        return 'salary_j.operators_index';
    }
}
