<?php namespace App\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Form\Type\OperatorGroupType;
use App\Entity\OperatorsGroup;

class OperatorsGroupForm extends AbstractForm
{
    /** @var string */
    protected $groupClass;
    
    /** @var RepositoryInterface */
    protected $repository;
    
    public function __construct(
        string $dataClass,
        RepositoryInterface $localesRepository,
        RequestStack $requestStack,
        RepositoryInterface $repository
    ) {
        parent::__construct( $dataClass );
        
        $this->localesRepository    = $localesRepository;
        $this->requestStack         = $requestStack;
        
        $this->groupClass   = $dataClass;
        $this->repository   = $repository;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        parent::buildForm( $builder, $options );
        
        $operatorsGroup = $options['data'];
        
        $builder
            ->setMethod( $operatorsGroup && $operatorsGroup->getId() ? 'PUT' : 'POST' )
        
            ->add( 'application_code', HiddenType::class, ['mapped' => false] )
            
            ->add( 'currentLocale', ChoiceType::class, [
                'label'                 => 'salary-j.form.locale',
                'translation_domain'    => 'SalaryJ',
                'choices'               => \array_flip( $this->fillLocaleChoices() ),
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
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver->setDefaults([
            'csrf_protection'   => false,
        ]);
    }
    
    public function getName()
    {
        return 'salary_j.operators_group';
    }
}
