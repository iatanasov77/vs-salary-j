<?php namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\Type\OperatorWorkOperatorType;

class OperatorsWorkCountForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'modelId', HiddenType::class, ['mapped' => false] )
            ->add( 'workDate', HiddenType::class, ['mapped' => false] )
        
            ->add( 'operators', CollectionType::class, [
                'allow_add'             => true,
                'allow_extra_fields'    => true,
                'entry_type'            => OperatorWorkOperatorType::class,
                'entry_options'         => ['label' => false],
            ])
            
            ->add( 'save', SubmitType::class, [
                'label'                 => 'salary-j.form.save',
                'translation_domain'    => 'SalaryJ',
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver->setDefaults([
            'csrf_protection'   => false,
        ]);
    }
    
    public function getName()
    {
        return 'salary_j.operators_work_count';
    }
}