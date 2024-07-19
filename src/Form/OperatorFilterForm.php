<?php namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContextInterface;
use App\Entity\OperatorsGroup;

class OperatorFilterForm extends AbstractType
{
    /** @var ApplicationContextInterface */
    private $applicationContext;
    
    public function __construct( ApplicationContextInterface $applicationContext )
    {
        $this->applicationContext   = $applicationContext;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options )
    {   
        $builder
            ->add( 'filter_groups', EntityType::class, [
                'label'                 => 'salary-j.form.group',
                'translation_domain'    => 'SalaryJ',
                'required'              => true,
                'class'                 => OperatorsGroup::class,
                'choice_label'          => 'name',
                'placeholder'           => 'salary-j.form.operators.operators_group_placeholder',
                
                'query_builder' => function( EntityRepository $repository ) {
                    $qb = $repository->createQueryBuilder( 'g' );
                    return $qb
                        ->where( 'g.application = :application' )
                        ->setParameter( 'application', $this->applicationContext->getApplication() )
                    ;
                },
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
}
