<?php namespace App\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Vankosoft\ApplicationBundle\Component\I18N;
use App\Form\Type\OperatorGroupType;
use App\Entity\OperatorsGroup;

class OperatorsGroupForm extends AbstractForm
{
    protected $groupClass;
    
    protected $repository;
    
    public function __construct( string $dataClass, EntityRepository $repository )
    {
        parent::__construct( $dataClass );
        
        $this->groupClass   = $dataClass;
        $this->repository   = $repository;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        parent::buildForm( $builder, $options );
        
        $operatorsGroup = $options['data'];
        
        $builder
            ->setMethod( $operatorsGroup && $operatorsGroup->getId() ? 'PUT' : 'POST' )
        
            ->add( 'application_code', HiddenType::class, ['mapped' => false] )
            
            ->add( 'currentLocale', ChoiceType::class, [
                'label'                 => 'salary-j.form.locale',
                'translation_domain'    => 'SalaryJ',
                'choices'               => \array_flip( I18N::LanguagesAvailable() ),
                'data'                  => \Locale::getDefault(),
                'mapped'                => false,
            ])
            
            ->add( 'parent', EntityType::class, [
                'label'                 => 'salary-j.form.operators_group.parent_operators_group',
                'translation_domain'    => 'SalaryJ',
                'class'                 => $this->groupClass,
                'query_builder'         => function ( EntityRepository $er ) use ( $operatorsGroup )
                {
                    $qb = $er->createQueryBuilder( 'pc' );
                    if  ( $operatorsGroup && $operatorsGroup->getId() ) {
                        $qb->where( 'pc.id != :id' )->setParameter( 'id', $operatorsGroup->getId() );
                    }
                    
                    return $qb;
                },
                'choice_label'  => 'name',
        
                'required'      => false,
                'placeholder'   => 'salary-j.form.operators_group.parent_operators_group_placeholder',
            ])
            
            ->add( 'operator_group', OperatorGroupType::class, [
                'mapped'        => false,
                'data_class'    => OperatorsGroup::class,
            ])
        ;
    }
    
    public function getName()
    {
        return 'salary_j.operators_group';
    }
}
