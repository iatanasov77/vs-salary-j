<?php namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\Type\OperationType;

class OperationsIndexForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'application_code', HiddenType::class, ['mapped' => false] )
            ->add( 'model_id', HiddenType::class )
            
            ->add( 'operations', CollectionType::class, [
                'allow_add'             => true,
                'allow_extra_fields'    => true,
                'entry_type'            => OperationType::class,
                'entry_options'         => ['label' => false],
            ])
            
            ->add( 'change_names', SubmitType::class, [
                'label'                 => 'salary-j.form.save',
                'translation_domain'    => 'SalaryJ',
            ])
            
            ->add( 'del_operations', SubmitType::class, [
                'label'                 => 'salary-j.form.operations.remove',
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
        return 'salary_j.operations_index';
    }
}
