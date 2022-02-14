<?php namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\OperatorsGroup;
use App\Entity\Operator;

class OperatorType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder            
            ->add( 'group', EntityType::class, [
                'label'                 => 'salary-j.form.group',
                'translation_domain'    => 'SalaryJ',
                'required'              => true,
                'class'                 => OperatorsGroup::class,
                'choice_label'          => 'name',
                
                // Not Use Placeholder
                //'placeholder'           => 'salary-j.form.common_group',
            ])
            
            ->add( 'name', TextType::class, [
                'label'                 => 'salary-j.form.name',
                'translation_domain'    => 'SalaryJ',
                'required'              => false,
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        //parent::configureOptions( $resolver );
        $resolver->setDefaults([
            'data_class' => Operator::class,
            'allow_extra_fields' => true,
        ]);
    }
}
