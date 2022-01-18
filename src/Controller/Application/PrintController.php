<?php namespace App\Controller\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;

use App\Repository\OperatorsWorkRepository;

class PrintController extends AbstractController
{
    /** @var TranslatorInterface */
    private $translator;
    
    /** @var ApplicationContext */
    private $applicationContext;
    
    /** @var EntityRepository */
    private $operatorsRepository;
    
    /** @var OperatorsWorkRepository */
    private $operatorsWorkRepository;
    
    /** @var EntityRepository */
    private $groupsRepository;
    
    public function __construct(
        TranslatorInterface $translator,
        ApplicationContext $applicationContext,
        EntityRepository $operatorsRepository,
        OperatorsWorkRepository $operatorsWorkRepository,
        EntityRepository $groupsRepository
    ) {
            $this->translator               = $translator;
            $this->applicationContext       = $applicationContext;
            $this->operatorsRepository      = $operatorsRepository;
            $this->operatorsWorkRepository  = $operatorsWorkRepository;
            $this->groupsRepository         = $groupsRepository;
    }
    
    public function printOperations( int $operatorId, $startDate, $endDate, Request $request ): Response
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
        
        return $this->render( 'pages/Print/operators_work_operations.html.twig', $tplVars );
    }
    
    public function printOperationsGrouped( int $operatorId, $startDate, $endDate, Request $request ): Response
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
        
        return $this->render( 'pages/Print/operators_work_operations_grouped.html.twig', $tplVars );
    }
    
    public function printOperatorsTotals( int $groupId, $startDate, $endDate, Request $request ): Response
    {
        $group              = $this->groupsRepository->find( $groupId );
        $dateRange          = $this->resolveDateRange( $startDate, $endDate );
        $work               = $this->operatorsWorkRepository->getOperatorsWork(
                                $groupId,
                                $startDate,
                                $endDate
                            );
        
        $tplVars = [
            'groupName' => $group ? $group->getName() : $this->translator->trans( 'salary-j.form.common_group', [], 'Application' ),
            'startDate' => new \DateTime( $startDate ),
            'endDate'   => new \DateTime( $endDate ),
            'group'     => $group,
            'work'      => $work,
            'dateRange' => $dateRange,
        ];
        
        return $this->render( 'pages/Print/operators_work_totals.html.twig', $tplVars );
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
