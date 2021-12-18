<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Sylius\Component\Resource\Factory\Factory;

use VS\ApplicationBundle\Component\Context\ApplicationContextInterface;

use App\Entity\UserManagement\User;
use VS\UsersBundle\Repository\UsersRepository;

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
        $application    = $this->applicationContext->getApplication();
        $users          = $this->repository->findAll();
        
        return $this->render( 'salary-j/pages/Users/index.html.twig', [
            'users' => $users,
            'form'  => $this->createUsersForm()->createView(),
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
}
