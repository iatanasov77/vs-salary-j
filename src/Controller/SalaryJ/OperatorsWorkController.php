<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use VS\ApplicationBundle\Component\Context\ApplicationContext;

use App\Repository\OperatorsWorkRepository;
use App\Entity\OperatorsWork;

class OperatorsWorkController extends AbstractController
{
    /** @var ApplicationContext */
    private $applicationContext;
    
    /** @var EntityRepository */
    private $operatorsRepository;
    
    /** @var OperatorsWorkRepository */
    private $operatorsWorkRepository;
    
    /** @var EntityRepository */
    private $modelsRepository;
    
    /** @var EntityRepository */
    private $operationsRepository;
    
    public function __construct(
        ApplicationContext $applicationContext,
        EntityRepository $operatorsRepository,
        OperatorsWorkRepository $operatorsWorkRepository,
        EntityRepository $modelsRepository,
        EntityRepository $operationsRepository
    ) {
            $this->applicationContext       = $applicationContext;
            $this->operatorsRepository      = $operatorsRepository;
            $this->operatorsWorkRepository  = $operatorsWorkRepository;
            $this->modelsRepository         = $modelsRepository;
            $this->operationsRepository     = $operationsRepository;
    }
    
    public function browseOperations( int $operatorId, Request $request ) : Response
    {
        $operator           = $this->operatorsRepository->find( $operatorId );
        
        $endDate            = new \DateTime();
        $startDate          = new \DateTime();
        $startDate->modify( '-7 day' );
        $dateRangeChanged   = false;
        if ( $request->isMethod( 'POST' ) ) {
            $startDate          = \DateTime::createFromFormat( 'Y-m-d', $request->request->get( 'startDate' ) );
            $endDate            = \DateTime::createFromFormat( 'Y-m-d', $request->request->get( 'endDate' ) );
            $dateRangeChanged   = $request->request->get( 'dateRangeChanged' );
        }
        $work       = $this->operatorsWorkRepository->getWorkForOperator( $operator, $startDate, $endDate );
        
        $tplVars = [
            'operator'  => $operator,
            'work'      => $work,
            'startDate' => $startDate->format( 'Y-m-d' ),
            'endDate'   => $endDate->format( 'Y-m-d' ),
        ];
        
        if ( $request->isMethod( 'POST' ) && $dateRangeChanged ) {
            return $this->render( 'salary-j/pages/Operations/Partial/operations.html.twig', $tplVars );
        }
        return $this->render( 'salary-j/pages/Operations/operators_work_browse_operations.html.twig', $tplVars );
    }
    
    public function browseOperationsGrouped( int $operatorId, Request $request ) : Response
    {
        $operator           = $this->operatorsRepository->find( $operatorId );
        $endDate            = new \DateTime();
        $startDate          = new \DateTime();
        $startDate->modify( '-7 day' );
        $dateRangeChanged   = false;
        if ( $request->isMethod( 'POST' ) ) {
            $startDate          = \DateTime::createFromFormat( 'Y-m-d', $request->request->get( 'startDate' ) );
            $endDate            = \DateTime::createFromFormat( 'Y-m-d', $request->request->get( 'endDate' ) );
            $dateRangeChanged   = $request->request->get( 'dateRangeChanged' );
        }
        $work       = $this->operatorsWorkRepository->getWorkForOperator( $operator, $startDate, $endDate );
        
        $tplVars = [
            'operator'  => $operator,
            'work'      => $work,
            'startDate' => $startDate->format( 'Y-m-d' ),
            'endDate'   => $endDate->format( 'Y-m-d' ),
        ];
        
        if ( $request->isMethod( 'POST' ) && $dateRangeChanged ) {
            return $this->render( 'salary-j/pages/Operations/Partial/operations_grouped.html.twig', $tplVars );
        }
        return $this->render( 'salary-j/pages/Operations/operators_work_browse_operations_grouped.html.twig', $tplVars );
    }
    
    public function addOperations( int $operatorId, Request $request ) : Response
    {
        $operator   = $this->operatorsRepository->find( $operatorId );
        $listModels = $this->modelsRepository->findAll();
        
        $tplVars = [
            'operator'      => $operator,
            'listModels'    => $listModels,
        ];
        
        return $this->render( 'salary-j/pages/Operations/operators_work_add_operations.html.twig', $tplVars );
    }
    
    public function submitWork( Request $request )
    {
        $em         = $this->getDoctrine()->getManager();
        $date       = \DateTime::createFromFormat( 'Y-m-d', $request->request->get( 'workDate' ) );
        
        $workCount  = $request->request->get( 'workCount' );
        foreach( $workCount as $operatorId => $operation ) {
            $operator   = $this->operatorsRepository->find( $operatorId );
            
            foreach( $operation as $operationId => $data ) {
                if( $data['workCount'] == $data['workCountOld'] )
                    continue;
                    
                $operation   = $this->operationsRepository->find( $operationId );
                if( empty( $data['workId'] ) ) {
                    $work   = new OperatorsWork();
                    
                    $work->setOperator( $operator );
                    $work->setOperation( $operation );
                    $work->setDate( $date );
                    $work->setCount( $data['workCount'] );
                    $work->setUnitPrice( $data['price'] );
                    
                    $em->persist( $work );
                }
                else {
                    $work   = $this->operatorsWorkRepository->findOneBy([
                        'operator'  => $operator,
                        'operation' => $operation,
                        'date'      => $date
                    ]);
                    
                    $work->setCount( $data['workCount'] );
                    $work->setUnitPrice( $data['price'] );
                    
                    $em->persist( $work );
                }
            }
        }
        
        $em->flush();
        return $this->redirect( $request->headers->get('referer') );
    }
}
