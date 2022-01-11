<?php namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Model;

class ModelType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ) : void
    {
        $builder
            ->add( 'number', TextType::class, [
                'label'                 => 'salary-j.form.number',
                'translation_domain'    => 'SalaryJ',
            ])
            
            ->add( 'name', TextType::class, [
                'label'                 => 'salary-j.form.name',
                'translation_domain'    => 'SalaryJ',
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        //parent::configureOptions( $resolver );
        $resolver->setDefaults([
            'data_class' => Model::class,
            'allow_extra_fields' => true,
        ]);
    }
}
