<?php namespace App\Form;

use VS\ApplicationBundle\Form\AbstractForm;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use VS\ApplicationBundle\Component\I18N;

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
                'mapped'                => false,
            ])
            
            ->add( 'name', TextType::class, [
                'label'                 => 'salary-j.form.name',
                'translation_domain'    => 'SalaryJ',
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
        ;
    }
    
    public function getName()
    {
        return 'salary_j.operators_group';
    }
}
