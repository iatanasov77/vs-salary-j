<?php namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

use Vankosoft\UsersBundle\Form\UserFormType;
use Vankosoft\UsersBundle\Form\Traits\UserInfoFormTrait;

use Vankosoft\UsersBundle\Model\UserInterface;

use App\Component\Orm;

class UserForm extends UserFormType
{
    use UserInfoFormTrait;
    
    /** @var Orm */
    private $ormComponent;
    
    public function __construct(
        string $dataClass,
        RepositoryInterface $localesRepository,
        RequestStack $requestStack,
        string $applicationClass,
        AuthorizationCheckerInterface $auth,
        array $requiredFields,
        Orm $ormComponent
    ) {
        parent::__construct( $dataClass, $localesRepository, $requestStack, $applicationClass, $auth, $requiredFields );
        
        $this->ormComponent = $ormComponent;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        parent::buildForm( $builder, $options );
        
        $this->buildUserInfoForm( $builder, $options );
        
        $builder->setMethod( 'POST' );
        
        $builder->remove( 'verified' );
        
        /**
         * Custom Fields
         */
        $builder
            ->add( 'mobile', TelType::class, [
                'mapped'                => false,
                'label'                 => 'salary-j.form.users.phone',
                'translation_domain'    => 'SalaryJ',
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver
            ->setDefined([
                'users',
            ])
            ->setAllowedTypes( 'users', UserInterface::class )
            
            ->setDefaults([
                'csrf_protection'       => false,
                
                'profilePictureMapped'  => false,
                'titleMapped'           => false,
                'firstNameMapped'       => false,
                'lastNameMapped'        => false,
                'designationMapped'     => false,
            ])
        ;
    }
}
