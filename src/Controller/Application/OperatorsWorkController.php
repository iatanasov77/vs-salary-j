<?php namespace App\Controller\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Twig\Environment;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;
use Vankosoft\ApplicationBundle\Component\Status;

use App\Repository\OperatorsWorkRepository;
use App\Entity\OperatorsWork;
use App\Entity\Operator;
use App\Entity\Operation;
use App\Form\OperatorFilterForm;
use App\Form\ModelsIndexForm;
use App\Form\OperationsIndexForm;
use App\Form\OperatorsWorkCountForm;

class OperatorsWorkController extends AbstractController
{
    /** @var ManagerRegistry */
    private $doctrine;
    
    /** @var Environment */
    private $templatingEngine;
    
    /** @var TranslatorInterface */
    private $translator;
    
    /** @var PaginatorInterface */
    private $paginator;
    
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
    
    /** @var EntityRepository */
    private $settingsRepository;
    
    public function __construct(
        ManagerRegistry $doctrine,
        Environment $templatingEngine,
        TranslatorInterface $translator,
        PaginatorInterface $paginator,
        ApplicationContext $applicationContext,
        EntityRepository $operatorsRepository,
        OperatorsWorkRepository $operatorsWorkRepository,
        EntityRepository $modelsRepository,
        EntityRepository $operationsRepository,
        EntityRepository $groupsRepository,
        EntityRepository $settingsRepository
    ) {
        $this->doctrine                 = $doctrine;
        $this->templatingEngine         = $templatingEngine;
        $this->translator               = $translator;
        $this->paginator                = $paginator;
        $this->applicationContext       = $applicationContext;
        $this->operatorsRepository      = $operatorsRepository;
        $this->operatorsWorkRepository  = $operatorsWorkRepository;
        $this->modelsRepository         = $modelsRepository;
        $this->operationsRepository     = $operationsRepository;
        $this->groupsRepository         = $groupsRepository;
        $this->settingsRepository       = $settingsRepository;
    }
    
    public function browseTotals( int $groupId, Request $request ): Response
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
        
        //echo "<pre>"; var_dump( $work ); die;
        $tplVars = [
            'groupId'       => $groupId,
            'group'         => $group,
            'dateRange'     => $dateRange,
            'work'          => $work,
            'filter_form'   => $filterForm->createView(),
        ];
        
        if ( $request->isMethod( 'POST' ) && $dateRangeChanged ) {
            return new JsonResponse([
                'groupName' => $group ? $group->getName() : $this->translator->trans( 'salary-j.form.common_group', [], 'Application' ),
                'workTable' => $this->templatingEngine->render( 'pages/OperatorsWork/Partial/operators_totals.html.twig', $tplVars )
            ]);
        }
        
        return $this->render( 'pages/OperatorsWork/operators_work_browse_totals.html.twig', $tplVars );
    }
    
    public function browseOperations( int $operatorId, Request $request ): Response
    {
        $operator           = $this->operatorsRepository->find( $operatorId );
        
        $dateRange          = $this->resolveDateRange( $request );
        $dateRangeChanged   = $request->request->get( 'dateRangeChanged' ) ? true : false;
        $work               = $this->operatorsWorkRepository->getWorkForOperator(
                                $operator,
                                $dateRange['startDate'],
                                $dateRange['endDate']
                            );
        //echo '<pre>'; var_dump( $work ); die;
        
        $tplVars = [
            'operator'  => $operator,
            'work'      => $work,
            'dateRange' => $dateRange,
        ];
        
        if ( $request->isMethod( 'POST' ) && $dateRangeChanged ) {
            return $this->render( 'pages/OperatorsWork/Partial/operations.html.twig', $tplVars );
        }
        return $this->render( 'pages/OperatorsWork/operators_work_browse_operations.html.twig', $tplVars );
    }
    
    public function browseOperationsGrouped( int $operatorId, Request $request ): Response
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
            return $this->render( 'pages/OperatorsWork/Partial/operations_grouped.html.twig', $tplVars );
        }
        return $this->render( 'pages/OperatorsWork/operators_work_browse_operations_grouped.html.twig', $tplVars );
    }
    
    public function addOperations( int $operatorId, Request $request ): Response
    {
        $application    = $this->applicationContext->getApplication();
        $operator       = $this->operatorsRepository->find( $operatorId );
        
        $listModels     = $this->paginator->paginate(
            $this->modelsRepository->getQueryBuilder( $application, 'jm' )->orderBy( 'jm.updatedAt', 'DESC' ),
            $request->query->getInt( 'page', 1 ) /*page number*/,
            30 /*limit per page*/
        );
        $listModels->setPageRange( 20 );
        
        $modelsIndexed  = [];
        foreach ( $listModels as $mod ) {
            $modelsIndexed[$mod->getId()] = $mod;
        }
        
        $tplVars        = [
            'operator'      => $operator,
            'listModels'    => $listModels,
            'index_form'    => $this->createForm( ModelsIndexForm::class, ['models' => $modelsIndexed] )->createView(),
        ];
        
        return $this->render( 'pages/OperatorsWork/operators_work_add_operations.html.twig', $tplVars );
    }
    
    public function addModelOperations( int $operatorId, int $modelId, Request $request ): Response
    {
        $operator           = $this->operatorsRepository->find( $operatorId );
        $model              = $this->modelsRepository->find( $modelId );
        
        $application        = $this->applicationContext->getApplication();
        $settings           = $this->settingsRepository->getSettings( $application->getId() );
        
        $operationsIndexed  = [];
        foreach ( $model->getOperations() as $op ) {
            $operationsIndexed[$op->getId()] = $op;
        }
        
        $queryDate      = $request->query->get( 'date' );
        $date           = $queryDate ? \DateTime::createFromFormat( 'Y-m-d', $queryDate ) : new \DateTime();
        
        $tplVars    = [
            'operator'      => $operator,
            'model'         => $model,
            'index_form'    => $this->createForm( OperationsIndexForm::class, ['operations' => $operationsIndexed] )->createView(),
            'operations'    => $operationsIndexed,
            'settings'      => $settings,
            'date'          => $date,
        ];
        
        return $this->render( 'pages/OperatorsWork/operators_work_add_model_operations.html.twig', $tplVars );
    }
    
    public function workCount( int $modelId, Request $request ): Response
    {
        $model              = $this->modelsRepository->find( $modelId );
        
        $dateRange          = $this->resolveDateRange( $request );
        $dateRangeChanged   = $request->request->get( 'dateRangeChanged' ) ? true : false;
        
        
        $operatorsWork  = $this->operatorsWorkRepository->getOperationsWorkCount(
            $modelId,
            $dateRange['startDate'],
            $dateRange['endDate'],
            true
            );
        
        $tplVars = [
            'model'         => $model,
            'dateRange'     => $dateRange,
            
            'operatorsWork' => $operatorsWork,
            'workCount'     => $this->getOperationsWorkCount( $operatorsWork['listOperations'] ),
        ];
        
        if ( $request->isMethod( 'POST' ) && $dateRangeChanged ) {
            return new JsonResponse([
                'modelName' => $model ? $model->getName() : $this->translator->trans( 'salary-j.form.common_group', [], 'Application' ),
                'workTable' => $this->templatingEngine->render( 'pages/Models/Partial/operations_work.html.twig', $tplVars )
            ]);
        }
        
        return $this->render( 'pages/Models/operations_work.html.twig', $tplVars );
    }
    
    public function workCountNew( int $modelId, Request $request ): Response
    {
        $model          = $this->modelsRepository->find( $modelId );
        $operators      = $this->operatorsRepository->findBy( ['application' => $this->applicationContext->getApplication()] );
        $settings       = $this->settingsRepository->getSettings( $this->applicationContext->getApplication()->getId() );
        
        $queryDate      = $request->query->get( 'date' );
        $date           = $queryDate ? \DateTime::createFromFormat( 'Y-m-d', $queryDate ) : new \DateTime();
        
        $operatorsWork  = $this->operatorsWorkRepository->getOperationsWorkCount(
            $modelId,
            $date->format( 'Y-m-d' ),
            $date->format( 'Y-m-d' ),
            false
        );
        //echo "<pre>"; var_dump( $operatorsWork ); die;
        
        /*
        $operatorsIndexed   = $this->operatorsIndexed( $operators );
        $workCountFormData  = $this->workCountFormData( $model, $operatorsIndexed );
        $workCountForm      = $this->createForm( OperatorsWorkCountForm::class, ['operators' => $workCountFormData], [
            'action'    => $this->generateUrl( 'app_operators_work_submit' ),
            'method'    => 'POST',
        ]);
        */
        
        $tplVars = [
            'model'             => $model,
            'operators'         => $operators,
            'settings'          => $settings,
            'date'              => $date,
            'operatorsWork'     => $operatorsWork,
            'workCount'         => $this->getOperatorsWorkCount( $operatorsWork['listOperations'], $date ),
            
//             'workCountForm'     => $workCountForm->createView(),
//             'operatorsIndexed'  => $operatorsIndexed,
        ];
        
        return $this->render( 'pages/Models/operators_work.html.twig', $tplVars );
    }
    
    public function submitWork( Request $request ): Response
    {
        //$this->debugWorksRepository();
        $formPost   = $request->request->all();
        
        $date       = \DateTime::createFromFormat( 'Y-m-d', $formPost['workDate'] );
        foreach( $formPost['workCount'] as $operatorId => $operation ) {
            $operator   = $this->operatorsRepository->find( $operatorId );
            
            foreach( $operation as $operationId => $data ) {
                if( $data['workCount'] == $data['workCountOld'] )
                    continue;
                    
                $operation  = $this->operationsRepository->find( $operationId );
                
                $this->saveWork( $operator, $operation, $date, $data );
            }
        }
        $this->doctrine->getManager()->flush();
        
        if( $request->isXmlHttpRequest() ) {
            return new JsonResponse([
                'status'    => Status::STATUS_OK,
            ]);
        } else {
            return $this->redirect( $request->headers->get( 'referer' ) );
        }
    }
    
    public function submitOperatorWork( Request $request ): Response
    {
        //$this->debugWorksRepository();
        $formPost   = $request->request->all();
        //echo '<pre>'; var_dump( $formPost ); die;
        
        foreach( $formPost['posted_data'] as $workId => $operationData ) {
            $work  = $this->operatorsWorkRepository->find( $workId );
            
            $this->saveOperatorWork( $work, $operationData );
        }
        $this->doctrine->getManager()->flush();
        
        return $this->redirect( $request->headers->get( 'referer' ) );
    }
    
    private function resolveDateRange( Request $request ): array
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
    
    private function saveWork( Operator $operator, Operation $operation, \DateTime $date, $data ): void
    {
        $em         = $this->doctrine->getManager();
        $maxWorkId  = $this->operatorsWorkRepository->getOperatorWorkMaxId( $operator->getId(), $operation->getId(), $date->format( 'Y-m-d' ) );
        //var_dump( $maxWorkId ); die;
        
        if( empty( $data['workId'] ) ) {
            $work   = new OperatorsWork();
            
            $work->setId( ++$maxWorkId );
            $work->setOperator( $operator );
            $work->setOperation( $operation );
            $work->setDate( $date );
            $work->setCreatedBy( $this->getUser() );
            
            $work->setCount( \intval( $data['workCount'] ) );
            $work->setUnitPrice( \floatval( $data['price'] ) );
        }
        else {
            $work   = $this->operatorsWorkRepository->findOneBy([
                'operator'  => $operator,
                'operation' => $operation,
                'date'      => $date,
            ]);
            
            $work->setId( ++$maxWorkId );
            $work->setUpdatedBy( $this->getUser() );
            
            $work->setCount( \intval( $data['workCount'] ) );
            $work->setUnitPrice( \floatval( $data['price'] ) );
        }
        
        $application    = $this->applicationContext->getApplication();
        $work->setApplication( $application );
        
        $em->persist( $work );
    }
    
    private function saveOperatorWork( OperatorsWork $work, $data ): void
    {
        $em = $this->doctrine->getManager();
        
        // @NOTE: I Dont Know If I Should Update Unit Price Here
        $operation  = $this->operationsRepository->find( $data['operation'] );
        $work->setUnitPrice( $operation->getPrice() );
        
        $work->setCount( \intval( $data['count'] ) );
        $em->persist( $work );
    }
    
    private function getOperationsWorkCount( $operations )
    {
        $workCount  = [];
        foreach( $operations as $op )  {
            $workCount[$op['operationId']]  = $op;
        }
        
        return $workCount;
    }
    
    private function getOperatorsWorkCount( $workedOperations, $date )
    {
        $workCount  = [];
        foreach( $workedOperations as $op )  {
            if( ! isset($workCount[$op['operatorId']] ) ) {
                $workCount[$op['operatorId']]   = [];
            }
            
            $workId = $op['operatorId'] . '_' . $date->format( 'Y-m-d' ) . '_' . $op['id'] . '_' . $op['operationId'];
            
            if( ! isset( $workCount[$op['operatorId']][$op['operationId']] ) ) {
                $workCount[$op['operatorId']][$op['operationId']]   = [
                    'workCount' => 0,
                    'workId'    => $workId,
                ];
            }
            
            $workCount[$op['operatorId']][$op['operationId']]['workCount']  += $op['count'];
        }
        //echo"<pre>"; var_dump( $workCount ); die;
        return $workCount;
    }
    
    private function operatorsIndexed( $operators ): array
    {
        $operatorsIndexed  = [];
        foreach ( $operators as $operator ) {
            $operatorsIndexed[$operator->getId()] = $operator;
        }
        
        return $operatorsIndexed;
    }
    
    private function workCountFormData( $model, $operatorsIndexed ): array
    {
        $workCountFormData  = [];
        foreach ( $operatorsIndexed as $operatorId => $operator ) {
            $workCountFormData[$operatorId] = ['operations'=> []];
            foreach ( $model->getOperations() as $operation ) {
                $workCountFormData[$operatorId]['operations'][$operation->getId()] = $operation;
            }
            //var_dump( \array_keys( $workCountFormData[$operatorId]['operations'] ) ); die;
        }
        
        return $workCountFormData;
    }
    
    private function debugWorksRepository(): void
    {
        $operator   = $this->operatorsRepository->find( 171 );
        $operation  = $this->operationsRepository->find( 93078 );
        $date       = \DateTime::createFromFormat( 'Y-m-d', '2021-05-24' );
        
        $maxWorkId  = $this->operatorsWorkRepository->getOperatorWorkMaxId( 171, 93078, '2021-05-24' );
        var_dump( $maxWorkId ); die;
    }
}
