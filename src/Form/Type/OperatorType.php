<?php namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContextInterface;
use App\Entity\OperatorsGroup;
use App\Entity\Operator;

class OperatorType extends AbstractType
{
    /** @var ApplicationContextInterface */
    private $applicationContext;
    
    public function __construct( ApplicationContextInterface $applicationContext )
    {
        $this->applicationContext   = $applicationContext;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            //->add( 'id', HiddenType::class, ['mapped' => true] )
        
            ->add( 'group', EntityType::class, [
                'label'                 => 'salary-j.form.group',
                'translation_domain'    => 'SalaryJ',
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
            'data_class' => Operator::class,
            'allow_extra_fields' => true,
        ]);
    }
}
