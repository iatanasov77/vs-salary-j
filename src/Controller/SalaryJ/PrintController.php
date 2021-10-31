<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use VS\ApplicationBundle\Component\Context\ApplicationContext;

use App\Repository\OperatorsWorkRepository;

class PrintController extends AbstractController
{
    /** @var ApplicationContext */
    private $applicationContext;
    
    /** @var EntityRepository */
    private $operatorsRepository;
    
    /** @var OperatorsWorkRepository */
    private $operatorsWorkRepository;
    
    public function __construct(
        ApplicationContext $applicationContext,
        EntityRepository $operatorsRepository,
        OperatorsWorkRepository $operatorsWorkRepository
    ) {
            $this->applicationContext       = $applicationContext;
            $this->operatorsRepository      = $operatorsRepository;
            $this->operatorsWorkRepository  = $operatorsWorkRepository;
    }
    
    public function printOperations( int $operatorId, Request $request ) : Response
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
    
    public function printOperationsGrouped( int $operatorId, Request $request ) : Response
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
}
