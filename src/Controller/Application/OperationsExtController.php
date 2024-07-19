<?php namespace App\Controller\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\Factory;

use Vankosoft\ApplicationBundle\Component\Context\ApplicationContextInterface;
use Vankosoft\ApplicationBundle\Component\Status;

use App\Form\OperationForm;
use App\Form\OperationsIndexForm;
use App\Entity\Operation;
use App\Repository\OperationsRepository;

class OperationsExtController extends AbstractController
{
    /** @var ManagerRegistry */
    private $doctrine;
    
    /** @var ApplicationContextInterface */
    private $applicationContext;
    
    /** @var EntityRepository */
    private $modelsRepository;
    
    /** @var EntityRepository */
    private $settingsRepository;
    
    /** @var OperationsRepository */
    private $operationsRepository;
    
    /** @var Factory */
    private $factory;
    
    public function __construct(
        ManagerRegistry $doctrine,
        ApplicationContextInterface $applicationContext,
        EntityRepository $modelsRepository,
        EntityRepository $settingsRepository,
        OperationsRepository $operationsRepository,
        Factory $factory
    ) {
        $this->doctrine             = $doctrine;
        $this->applicationContext   = $applicationContext;
        $this->modelsRepository     = $modelsRepository;
        $this->settingsRepository   = $settingsRepository;
        $this->operationsRepository = $operationsRepository;
        $this->factory              = $factory;
    }
    
    public function save( $modelId, Request $request ) : Response
    {
        $form           = $this->createForm( OperationForm::class );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $em     = $this->doctrine->getManager();
            $entity = $form->getData();
            
            $entity->setApplication( $this->applicationContext->getApplication() );
            $entity->setModel( $this->modelsRepository->find( $modelId ) );
            
            if ( $entity->getId() ) {
                $entity->setUpdatedBy( $this->getUser() );
            } else {
                $entity->setCreatedBy( $this->getUser() );
            }
            $formValues = $request->request->all( 'operation_form' );
            
            // Set Operation Data
            $entity->setOperationId( $formValues['operation']['operationId'] );
            $entity->setOperationName( $formValues['operation']['operationName'] );
            
            $settings       = $this->settingsRepository->getSettings( $this->applicationContext->getApplication()->getId() );
            $minutes        = $formValues['operation']['minutes'];
            $priceByMinutes = $minutes * ( 1 + ( $settings['minuteBonus']['value'] / 100 ) ) * $settings['minuteRate']['value'];
            
            $entity->setPrice( $priceByMinutes );
            $entity->setMinutes( $minutes );
            
            $em->persist( $entity );
            $em->flush();
            
            return $this->redirect( $this->generateUrl( 'app_operations_index', ['modelId' => $modelId] ) );
        }
        
        return new Response( 'The form is not hanled properly !!!', Response::HTTP_BAD_REQUEST );
    }
    
    public function updateOperations( $modelId, Request $request ): JsonResponse
    {
        $em     = $this->doctrine->getManager();
        $form   = $this->createForm( OperationsIndexForm::class );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $operations         = $form->get( 'operations' )->getData();
            $submitedOperations = $request->get( 'opids' );
            //echo '<pre>'; var_dump( \array_keys( $operations[$submitedOperations[0]] ) ); die;
            
            if ( is_array( $submitedOperations ) ) {
                $settings   = $this->settingsRepository->getSettings( $this->applicationContext->getApplication()->getId() );
                
                foreach( array_keys( $submitedOperations ) as $operationId ) {
                    $operation  = $this->operationsRepository->find( $operationId );
                    
                    $minutes        = $operations[$operationId]->getMinutes();
                    $priceByMinutes = $minutes * ( 1 + ( $settings['minuteBonus']['value'] / 100 ) ) * $settings['minuteRate']['value'];
                    
                    $operation->setOperationId( $operations[$operationId]->getOperationId() );
                    $operation->setOperationName( $operations[$operationId]->getOperationName() );
                    $operation->setMinutes( $minutes  );
                    $operation->setPrice( $priceByMinutes );
                    
                    $em->persist( $operation );
                }
                $em->flush();
            }
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
        
    public function deleteOperations( $modelId, Request $request ): JsonResponse
    {
        $em     = $this->doctrine->getManager();
        $form   = $this->createForm( OperationsIndexForm::class );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $submitedOperations = $request->get( 'opids' );
            
            if ( is_array( $submitedOperations ) ) {
                foreach( array_keys( $submitedOperations ) as $operationId ) {
                    $operation  = $this->operationsRepository->find( $operationId );
                    
                    $operation->setDeletedBy( $this->getUser() );
                    $em->persist( $operation );
                    $em->flush(); // Need Flush() to save deleted_by_id field
                    
                    $em->remove( $operation );
                }
                $em->flush();
            }
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
}
