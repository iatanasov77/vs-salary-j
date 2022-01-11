<?php namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

use Vankosoft\UsersBundle\Form\UserFormType;
use Vankosoft\UsersBundle\Form\Traits\UserInfoFormTrait;

use Vankosoft\UsersBundle\Model\UserInterface;

use App\Component\Orm;

class UserForm extends UserFormType
{
    use UserInfoFormTrait;
    
    private Orm $ormComponent;
    
    public function __construct(
        RequestStack $requestStack,
        string $dataClass,
        string $applicationClass,
        Orm $ormComponent
    ) {
        parent::__construct( $requestStack, $dataClass, $applicationClass );
        
        $this->ormComponent = $ormComponent;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        parent::buildForm( $builder, $options );
        
        $this->buildUserInfoForm( $builder, $options );
        
        $builder->setMethod( 'POST' );
        
        $builder->remove( 'verified' );
        $builder->remove( 'applications' );
        
        /**
         * Custom Fields
         */
        $builder
            // UserInfo: Title
            ->add( 'title', ChoiceType::class, [
                'mapped'                => false,
                'label'                 => 'salary-j.form.users.user_title',
                'translation_domain'    => 'SalaryJ',
                'choices'               => \array_flip( $this->ormComponent->userTitleChoices() ),
            ])
            
            ->add( 'mobile', TelType::class, [
                'mapped'                => false,
                'label'                 => 'salary-j.form.users.phone',
                'translation_domain'    => 'SalaryJ',
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ) : void
    {
        parent::configureOptions( $resolver );
        
        $resolver
            ->setDefined([
                'users',
            ])
            ->setAllowedTypes( 'users', UserInterface::class )
            
            ->setDefaults([
                'profilePictureMapped'  => false,
                'firstNameMapped'       => false,
                'lastNameMapped'        => false,
            ])
        ;
    }
}
