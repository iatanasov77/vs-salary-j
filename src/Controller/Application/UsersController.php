<?php namespace App\Controller\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Sylius\Component\Resource\Factory\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Vankosoft\ApplicationBundle\Component\Context\ApplicationContextInterface;
use Vankosoft\ApplicationBundle\Repository\ApplicationRepositoryInterface;
use Vankosoft\UsersBundle\Security\UserManager;
use Vankosoft\UsersBundle\Repository\UsersRepository;
use Vankosoft\UsersBundle\Repository\UserRolesRepository;
use App\Entity\UserManagement\User;
use App\Form\UserForm;

class UsersController extends AbstractController
{
    /** @var ApplicationContextInterface */
    private $applicationContext;
    
    /** @var ApplicationRepositoryInterface */
    private $applicationRepository;
    
    /** @var UserManager */
    private $userManager;
    
    /** @var UsersRepository */
    private $repository;
    
    /** @var Factory */
    private $factory;
    
    /** @var Factory */
    private $factoryInfo;
    
    /** @var UserRolesRepository */
    private $repositoryRoles;
    
    public function __construct(
        ApplicationContextInterface $applicationContext,
        ApplicationRepositoryInterface $applicationRepository,
        UserManager $userManager,
        UsersRepository $repository,
        Factory $factory,
        Factory $factoryInfo,
        UserRolesRepository $repositoryRoles
    ) {
        $this->applicationContext       = $applicationContext;
        $this->applicationRepository    = $applicationRepository;
        $this->userManager              = $userManager;
        $this->repository               = $repository;
        $this->factory                  = $factory;
        $this->factoryInfo              = $factoryInfo;
        $this->repositoryRoles          = $repositoryRoles;
    }
    
    public function index( Request $request ) : Response
    {
        return $this->render( 'pages/Users/index.html.twig', [
            'users' => $this->getDisplayUsers(),
            'form'  => $this->createUsersForm()->createView(),
        ]);
    }
    
    public function update( $userId, Request $request ) : Response
    {
        $user   = $userId ? $this->repository->find( $userId ) : $this->factory->createNew();
        $form   = $this->createForm( UserForm::class, $user );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $form->getData();
            
            $entity->setPreferedLocale( $request->getLocale() );
            $entity->setVerified( true );
            
            $plainPassword  = $form->get( "plain_password" )->getData();
            if ( $plainPassword ) {
                $this->userManager->encodePassword( $entity, $plainPassword );
            }
            
            $this->buildInfo( $entity, $form );
            $this->buildPermissions( $entity, $form );
            
            $em->persist( $entity );
            $em->flush();
            
            return $this->redirect( $this->generateUrl( 'salaryj_users_index' ) );
        }
        
        return $this->render( 'pages/Users/update.html.twig', [
            'form'  => $form->createView(),
            'user'  => $user,
        ]);
    }
    
    private function createUsersForm()
    {
        $fb = $this->createFormBuilder();
        
        return $fb->add( 'save', SubmitType::class, [
            'label' => 'salary-j.form.save',
            'translation_domain' => 'Application'
        ])->getForm();
    }
    
    private function getDisplayUsers(): array
    {
        $application    = $this->applicationContext->getApplication();
        $users          = $this->repository->findAll();
       
        $displayUsers   = [];
        $displayUsers[$this->getUser()->getUsername()] = $this->getUser();
        
        $rolesAncestors = new ArrayCollection();
        foreach ( $users as $u ) {
            if ( $this->isGranted( 'ROLE_SUPER_ADMIN' ) ) {
                $displayUsers[$u->getUsername()] = $u;
            } else {
                $rolesAncestors = $u->getRolesAncestors();
                foreach ( $this->getUser()->getRolesCollection() as $ur ) {
                    if ( $u->getApplications()->contains( $application ) || $rolesAncestors->contains( $ur ) ) {
                        $displayUsers[$u->getUsername()] = $u;
                        break;
                    }
                }
            }
        }
        //var_dump( $this->getUser()->getRolesAncestors() ); die;
        
        return $displayUsers;
    }
    
    private function buildInfo( &$entity, $form  )
    {
        $infoEntity = $entity->getInfo();
        if ( ! $infoEntity ) {
            $infoEntity = $this->factoryInfo->createNew();
        }
        
        $infoEntity->setTitle( $form->get( "title" )->getData() );
        $infoEntity->setFirstName( $form->get( "firstName" )->getData() );
        $infoEntity->setLastName( $form->get( "lastName" )->getData() );
        $infoEntity->setMobile( $form->get( "mobile" )->getData() );
        
        $entity->setInfo( $infoEntity );
    }
    
    private function buildPermissions( &$entity, $form )
    {
        $entity->setRolesCollection( new ArrayCollection() );
        
        if ( $this->isGranted( 'ROLE_APPLICATION_ADMIN' ) ) {
            $role                   = $this->repositoryRoles->findByTaxonCode( 'role-application-admin' );
            $allowedApplications    = $form->get( "applications" )->getData();
        } else {
            $application            = $this->applicationContext->getApplication();
            $role                   = $this->repositoryRoles->findByTaxonCode( 'role-junona-dimitrovgrad' );
            
            $allowedApplications    = [$application];
        }
        
        $entity->addRole( $role );
        
        $this->clearApplications( $entity );
        $entity->setApplications( $allowedApplications );
    }
    
    /**
     * Used before setApplications method to fix when removing an application
     * MANUAL: https://stackoverflow.com/questions/38955114/symfony-doctrine-remove-manytomany-association/38955917
     */
    private function clearApplications( &$entity )
    {
        $userApps   = $entity->getApplications();
        
        foreach ( $this->applicationRepository->findAll() as $app ) {
            if ( ! $userApps->contains( $app ) ) {
                $app->removeUser( $entity );
            }
        }
        
        return $this;
    }
}
