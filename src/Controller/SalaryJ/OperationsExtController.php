<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\Factory;

use VS\ApplicationBundle\Component\Context\ApplicationContextInterface;

use App\Form\OperationForm;
use App\Entity\Operation;
use App\Repository\OperationsRepository;

class OperationsExtController extends AbstractController
{
    /** @var ApplicationContextInterface */
    private $applicationContext;
    
    /** @var EntityRepository */
    private $modelsRepository;
    
    /** @var OperationsRepository */
    private $operationsRepository;
    
    /** @var Factory */
    private $factory;
    
    public function __construct(
        ApplicationContextInterface $applicationContext,
        EntityRepository $modelsRepository,
        OperationsRepository $operationsRepository,
        Factory $factory
    ) {
        $this->applicationContext   = $applicationContext;
        $this->modelsRepository     = $modelsRepository;
        $this->operationsRepository = $operationsRepository;
        $this->factory              = $factory;
    }
    
    public function save( $modelId, Request $request ) : Response
    {
        $form           = $this->createForm( OperationForm::class );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $form->getData();
            
            $entity->setApplication( $this->applicationContext->getApplication() );
            $entity->setModel( $this->modelsRepository->find( $modelId ) );
            
            $em->persist( $entity );
            $em->flush();
            
            return $this->redirect( $this->generateUrl( 'app_model_browse_operations', ['modelId' => $modelId] ) );
        }
        
        return new Response( 'The form is not hanled properly !!!', Response::HTTP_BAD_REQUEST );
    }
}
