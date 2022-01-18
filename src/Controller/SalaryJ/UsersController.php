<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Sylius\Component\Resource\Factory\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Vankosoft\ApplicationBundle\Component\Context\ApplicationContextInterface;
use Vankosoft\UsersBundle\Repository\UsersRepository;
use App\Entity\UserManagement\User;
use App\Form\UserForm;

class UsersController extends AbstractController
{
    /** @var ApplicationContextInterface */
    private $applicationContext;
    
    /** @var SettingsRepository */
    private $repository;
    
    /** @var Factory */
    private $factory;
    
    public function __construct(
        ApplicationContextInterface $applicationContext,
        UsersRepository $repository,
        Factory $factory
    ) {
        $this->applicationContext   = $applicationContext;
        $this->repository           = $repository;
        $this->factory              = $factory;
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
            'translation_domain' => 'SalaryJ'
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
            $rolesAncestors = $u->getRolesAncestors();
            foreach ( $this->getUser()->getRolesCollection() as $ur ) {
                if ( $u->getApplications()->contains( $application ) || $rolesAncestors->contains( $ur ) ) {
                    $displayUsers[$u->getUsername()] = $u;
                    break;
                }
            }
        }
        //var_dump( $this->getUser()->getRolesAncestors() ); die;
        
        return $displayUsers;
    }
    
    private function getRolesAncestors( $r ): Collection
    {
        $ancestors = [];
        
        for ( $ancestor = $r->getParent(); null !== $ancestor; $ancestor = $ancestor->getParent() ) {
            array_push( $ancestors, $ancestor );
        }

        return new ArrayCollection( $ancestors );
    }
}
