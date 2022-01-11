<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;
use Vankosoft\ApplicationBundle\Component\Status;

use App\Form\OperatorsIndexForm;

class OperatorsExtController extends AbstractController
{
    /** @var ApplicationContext */
    private $applicationContext;
    
    /** @var EntityRepository */
    private $operatorsRepository;
    
    public function __construct(
        ApplicationContext $applicationContext,
        EntityRepository $operatorsRepository
    ) {
        $this->applicationContext       = $applicationContext;
        $this->operatorsRepository      = $operatorsRepository;
    }
    
    public function updateOperators( Request $request ): JsonResponse
    {
        $em     = $this->getDoctrine()->getManager();
        $form   = $this->createForm( OperatorsIndexForm::class, ['operators' => $this->getOperators()] );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $operators          = $form->get( 'operators' )->getData();
            $submitedOperators  = $request->get( 'submitedOperators' );
            if ( is_array( $submitedOperators ) ) {
                foreach( array_keys( $submitedOperators ) as $operatorId ) {
                    $em->persist( $operators[$operatorId] );
                }
            }
            $em->flush();
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
    
    public function deleteOperators( Request $request ): JsonResponse
    {
        $em     = $this->getDoctrine()->getManager();
        $form   = $this->createForm( OperatorsIndexForm::class, ['operators' => $this->getOperators()] );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $operators          = $form->get( 'operators' )->getData();
            $submitedOperators  = $request->get( 'submitedOperators' );
            if ( is_array( $submitedOperators ) ) {
                foreach( array_keys( $submitedOperators ) as $operatorId ) {
                    $operators[$operatorId]->setDeletedBy( $this->getUser() );
                    $em->persist( $operators[$operatorId] );
                    $em->flush(); // Need Flush() to save deleted_by_id field
                    
                    $em->remove( $operators[$operatorId] );
                }
                $em->flush();
            }
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
    
    private function getOperators(): array
    {
        $filterGroup    = null;
        $operators  = $this->operatorsRepository->findBy( ['group' => $filterGroup] );
        $operatorsIndexed = [];
        foreach ( $operators as $op ) {
            $operatorsIndexed[$op->getId()] = $op;
        }
        
        return $operatorsIndexed;
    }
}
