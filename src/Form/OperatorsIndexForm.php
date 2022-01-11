<?php namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\Type\OperatorType;

class OperatorsIndexForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'operators', CollectionType::class, [
                'allow_add'             => true,
                'allow_extra_fields'    => true,
                'entry_type'            => OperatorType::class,
                'entry_options'         => ['label' => false],
            ])
            ->add( 'change_names', SubmitType::class, [
                'label'                 => 'salary-j.form.save',
                'translation_domain'    => 'SalaryJ',
            ])
            ->add( 'del_operators', SubmitType::class, [
                'label'                 => 'salary-j.form.models.remove',
                'translation_domain'    => 'SalaryJ',
            ])
        ;
    }
    
    public function getName()
    {
        return 'salary_j.operators_index';
    }
}
