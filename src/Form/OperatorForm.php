<?php namespace App\Form;

use VS\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\OperatorsGroup;

class OperatorForm extends AbstractForm
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        parent::buildForm( $builder, $options );
        
        $builder
            ->add( 'application_code', HiddenType::class, ['mapped' => false] )
        
            ->add( 'group', EntityType::class, [
                'label'                 => 'salary-j.form.group',
                'translation_domain'    => 'SalaryJ',
                'required'              => false,
                'class'                 => OperatorsGroup::class,
                'choice_label'          => 'name',
                'placeholder'           => 'salary-j.form.common_group',
            ])
            
            ->add( 'name', TextType::class, [
                'label'                 => 'salary-j.form.name',
                'translation_domain'    => 'SalaryJ',
            ])
        ;
    }
    
    public function getName()
    {
        return 'salary_j.operator';
    }
}
