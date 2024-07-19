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
    
    /** @var EntityRepository */
    private $modelsRepository;
    
    public function __construct(
        TranslatorInterface $translator,
        ApplicationContext $applicationContext,
        EntityRepository $operatorsRepository,
        OperatorsWorkRepository $operatorsWorkRepository,
        EntityRepository $groupsRepository,
        EntityRepository $modelsRepository
    ) {
            $this->translator               = $translator;
            $this->applicationContext       = $applicationContext;
            $this->operatorsRepository      = $operatorsRepository;
            $this->operatorsWorkRepository  = $operatorsWorkRepository;
            $this->groupsRepository         = $groupsRepository;
            $this->modelsRepository         = $modelsRepository;
    }
    
    public function printOperations( int $operatorId, string $startDate, string $endDate, Request $request ): Response
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
    
    public function printOperationsGrouped( int $operatorId, string $startDate, string $endDate, Request $request ): Response
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
    
    public function printOperatorsTotals( int $groupId, string $startDate, string $endDate, Request $request ): Response
    {
        $startDate          = new \DateTime( $startDate );
        $endDate            = new \DateTime( $endDate );
        
        $group              = $this->groupsRepository->find( $groupId );
        $work               = $this->operatorsWorkRepository->getOperatorsWork(
                                $groupId,
                                $startDate,
                                $endDate
                            );
        
        $tplVars = [
            'groupName' => $group ? $group->getName() : $this->translator->trans( 'salary-j.form.common_group', [], 'Application' ),
            'startDate' => $startDate ,
            'endDate'   => $endDate,
            'group'     => $group,
            'work'      => $work,
        ];
        
        return $this->render( 'pages/Print/operators_work_totals.html.twig', $tplVars );
    }
    
    public function printModelWork( int $modelId, string $startDate, string $endDate, Request $request ): Response
    {
        $model              = $this->modelsRepository->find( $modelId );
        $dateRange          = $this->resolveDateRange( $startDate, $endDate );
        $work               = $this->operatorsWorkRepository->getOperationsWorkCount(
            $modelId,
            $dateRange['startDate'],
            $dateRange['endDate'],
            true
        );
        
        $tplVars = [
            'model'     => $model,
            'startDate' => new \DateTime( $startDate ),
            'endDate'   => new \DateTime( $endDate ),
            'work'      => $work,
            'workCount' => $this->getOperationsWorkCount( $work['listOperations'] ),
        ];
        
        return $this->render( 'pages/Print/operations_work.html.twig', $tplVars );
    }
    
    private function resolveDateRange( string $queryStartDate, string $queryEndDate ) : array
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
    
    private function getOperationsWorkCount( array $operations )
    {
        $workCount  = [];
        foreach( $operations as $op )  {
            $workCount[$op['operationId']]  = $op;
        }
        
        return $workCount;
    }
}
