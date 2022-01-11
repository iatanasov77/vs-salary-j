<?php namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\OperatorsGroup;

class OperatorFilterForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {   
        $builder
            ->add( 'filter_groups', EntityType::class, [
                'label'                 => 'salary-j.form.group',
                'translation_domain'    => 'SalaryJ',
                'required'              => true,
                'class'                 => OperatorsGroup::class,
                'choice_label'          => 'name',
                
                // Not Use Placeholder
                //'placeholder'           => 'salary-j.form.common_group',
            ])   
        ;
    }
}
