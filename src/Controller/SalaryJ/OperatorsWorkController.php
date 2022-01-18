<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;

use App\Repository\OperatorsWorkRepository;
use App\Entity\OperatorsWork;
use App\Form\OperatorFilterForm;

class OperatorsWorkController extends AbstractController
{
    /** @var Environment */
    private $templatingEngine;
    
    /** @var TranslatorInterface */
    private $translator;
    
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
    
    /** @var EntityRepository */
    private $groupsRepository;
    
    public function __construct(
        Environment $templatingEngine,
        TranslatorInterface $translator,
        ApplicationContext $applicationContext,
        EntityRepository $operatorsRepository,
        OperatorsWorkRepository $operatorsWorkRepository,
        EntityRepository $modelsRepository,
        EntityRepository $operationsRepository,
        EntityRepository $groupsRepository
    ) {
            $this->templatingEngine         = $templatingEngine;
            $this->translator               = $translator;
            $this->applicationContext       = $applicationContext;
            $this->operatorsRepository      = $operatorsRepository;
            $this->operatorsWorkRepository  = $operatorsWorkRepository;
            $this->modelsRepository         = $modelsRepository;
            $this->operationsRepository     = $operationsRepository;
            $this->groupsRepository         = $groupsRepository;
    }
    
    public function browseTotals( int $groupId, Request $request ) : Response
    {
        $group              = $this->groupsRepository->find( $groupId );
        
        $dateRange  = $this->resolveDateRange( $request );
        $dateRangeChanged   = $request->request->get( 'dateRangeChanged' ) ? true : false;
        $work       = $this->operatorsWorkRepository->getOperatorsWork(
                        $groupId,
                        $dateRange['startDate'],
                        $dateRange['endDate']
                    );
        
        $filterForm = $this->createForm( OperatorFilterForm::class );
        $filterForm->get( 'filter_groups' )->setData( $group );
        
        //var_dump( $work ); die;
        $tplVars = [
            'groupId'       => $groupId,
            'group'         => $group,
            'dateRange'     => $dateRange,
            'work'          => $work,
            'filter_form'   => $filterForm->createView(),
        ];
        
        if ( $request->isMethod( 'POST' ) && $dateRangeChanged ) {
            return new JsonResponse([
                'groupName' => $group ? $group->getName() : $this->translator->trans( 'salary-j.form.common_group', [], 'SalaryJ' ),
                'workTable' => $this->templatingEngine->render( 'pages/Operations/Partial/operators_totals.html.twig', $tplVars )
            ]);
        }
        
        return $this->render( 'pages/Operations/operators_work_browse_totals.html.twig', $tplVars );
    }
    
    public function browseOperations( int $operatorId, Request $request ) : Response
    {
        $operator           = $this->operatorsRepository->find( $operatorId );
        
        $dateRange          = $this->resolveDateRange( $request );
        $dateRangeChanged   = $request->request->get( 'dateRangeChanged' ) ? true : false;
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
        
        if ( $request->isMethod( 'POST' ) && $dateRangeChanged ) {
            return $this->render( 'pages/Operations/Partial/operations.html.twig', $tplVars );
        }
        return $this->render( 'pages/Operations/operators_work_browse_operations.html.twig', $tplVars );
    }
    
    public function browseOperationsGrouped( int $operatorId, Request $request ) : Response
    {
        $operator           = $this->operatorsRepository->find( $operatorId );
        $dateRange          = $this->resolveDateRange( $request );
        $dateRangeChanged   = $request->request->get( 'dateRangeChanged' ) ? true : false;
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
        
        if ( $request->isMethod( 'POST' ) && $dateRangeChanged ) {
            return $this->render( 'pages/Operations/Partial/operations_grouped.html.twig', $tplVars );
        }
        return $this->render( 'pages/Operations/operators_work_browse_operations_grouped.html.twig', $tplVars );
    }
    
    public function addOperations( int $operatorId, Request $request ) : Response
    {
        $operator   = $this->operatorsRepository->find( $operatorId );
        $listModels = $this->modelsRepository->findAll();
        
        $tplVars = [
            'operator'      => $operator,
            'listModels'    => $listModels,
        ];
        
        return $this->render( 'pages/Operations/operators_work_add_operations.html.twig', $tplVars );
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
                    $work->setCreatedBy( $this->getUser() );
                    
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
                    $work->setUpdatedBy( $this->getUser() );
                    
                    $em->persist( $work );
                }
            }
        }
        
        $em->flush();
        return $this->redirect( $request->headers->get('referer') );
    }
    
    private function resolveDateRange( Request $request ) : array
    {
        $queryStartDate     = $request->request->get( 'startDate' );
        $queryEndDate       = $request->request->get( 'endDate' );
        
        if ( $queryStartDate && $queryEndDate ) {
            $startDate          = \DateTime::createFromFormat( 'Y-m-d', $queryStartDate );
            $endDate            = \DateTime::createFromFormat( 'Y-m-d', $queryEndDate );
            $startDate->setTime( 0, 0 );
        } else {
            $endDate            = new \DateTime();
            $startDate          = new \DateTime();
            $startDate->modify( '-7 day' );
            $startDate->setTime( 0, 0 );
        }
        //echo "<pre>"; var_dump( \DateTime::getLastErrors() ); die;
        
        return [
            'startDate' => $startDate,
            'endDate'   => $endDate
        ];
    }
}
