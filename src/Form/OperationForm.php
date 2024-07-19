<?php namespace App\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Form\Type\OperationType;
use App\Entity\Operation;

class OperationForm extends AbstractForm
{
    public function __construct(
        string $dataClass,
        RepositoryInterface $localesRepository,
        RequestStack $requestStack
    ) {
        parent::__construct( $dataClass );
        
        $this->localesRepository    = $localesRepository;
        $this->requestStack         = $requestStack;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        parent::buildForm( $builder, $options );
        
        $operation  = isset( $options['data'] ) ? $options['data'] : null;
        $builder
            ->setMethod( $operation && $operation->getId() ? 'PUT' : 'POST' )
            
            ->add( 'application_code', HiddenType::class, ['mapped' => false] )
            
            ->add( 'currentLocale', ChoiceType::class, [
                'label'                 => 'salary-j.form.locale',
                'translation_domain'    => 'SalaryJ',
                'choices'               => \array_flip( $this->fillLocaleChoices() ),
                'mapped'                => false,
            ])
            
            ->add( 'price', HiddenType::class )
            
            ->add( 'operation', OperationType::class, [
                'mapped'        => false,
                'data_class'    => Operation::class,
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
