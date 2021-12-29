<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;

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
    
    public function printOperations( int $operatorId, $startDate, $endDate, Request $request ) : Response
    {
        $operator           = $this->operatorsRepository->find( $operatorId );
        $dateRange          = $this->resolveDateRange( $startDate, $endDate );
        $work               = $this->operatorsWorkRepository->getWorkForOperator(
                                $operator,
                                $dateRange['startDate'],
                                $dateRange['endDate']
                            );
        
        $tplVars = [
            'operator'  => $operator,
            'work'      => $work,
            'dateRange' => $dateRange,
        ];
        
        return $this->render( 'salary-j/pages/Print/operators_work_operations.html.twig', $tplVars );
    }
    
    public function printOperationsGrouped( int $operatorId, $startDate, $endDate, Request $request ) : Response
    {
        $operator           = $this->operatorsRepository->find( $operatorId );
        $dateRange          = $this->resolveDateRange( $startDate, $endDate );
        $work               = $this->operatorsWorkRepository->getWorkForOperator(
                                $operator,
                                $dateRange['startDate'],
                                $dateRange['endDate'],
                                true
                            );
        
        $tplVars = [
            'operator'  => $operator,
            'work'      => $work,
            'dateRange' => $dateRange,
        ];
        
        return $this->render( 'salary-j/pages/Print/operators_work_operations_grouped.html.twig', $tplVars );
    }
    
    private function resolveDateRange( $queryStartDate, $queryEndDate ) : array
    {
        $startDate          = \DateTime::createFromFormat( 'Y-m-d', $queryStartDate );
        $endDate            = \DateTime::createFromFormat( 'Y-m-d', $queryEndDate );
        $startDate->setTime( 0, 0 );
        //echo "<pre>"; var_dump( \DateTime::getLastErrors() ); die;
        
        return [
            'startDate' => $startDate,
            'endDate'   => $endDate
        ];
    }
}
