<?php namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\Type\OperatorGroupType;

class OperatorsGroupsIndexForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'operators_groups', CollectionType::class, [
                'allow_add'             => true,
                'allow_extra_fields'    => true,
                'entry_type'            => OperatorGroupType::class,
                'entry_options'         => ['label' => false],
            ])
            
            ->add( 'change_names', SubmitType::class, [
                'label'                 => 'salary-j.form.save',
                'translation_domain'    => 'SalaryJ',
            ])
            
            ->add( 'del_groups', SubmitType::class, [
                'label'                 => 'salary-j.form.remove',
                'translation_domain'    => 'SalaryJ',
            ])
        ;
    }
    
    public function getName()
    {
        return 'salary_j.operators_groups_index';
    }
}