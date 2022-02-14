<?php namespace App\Controller\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;
use Vankosoft\ApplicationBundle\Component\Status;

use App\Form\OperationForm;
use App\Repository\OperationsRepository;
use App\Repository\SettingsRepository;
use App\Repository\OperatorsWorkRepository;
use App\Form\ModelsIndexForm;

class ModelsExtController extends AbstractController
{
    /** @var Environment */
    private $templatingEngine;
    
    /** @var TranslatorInterface */
    private $translator;
    
    /** @var ApplicationContext */
    private $applicationContext;
    
    /** @var EntityRepository */
    private $modelsRepository;
    
    /** @var OperationsRepository */
    private $operationsRepository;
    
    /** @var EntityRepository */
    private $operatorsRepository;
    
    /** @var SettingsRepository */
    private $settingsRepository;
    
    /** @var OperatorsWorkRepository */
    private $operatorsWorkRepository;
    
    public function __construct(
        Environment $templatingEngine,
        TranslatorInterface $translator,
        ApplicationContext $applicationContext,
        EntityRepository $modelsRepository,
        OperationsRepository $operationsRepository,
        EntityRepository $operatorsRepository,
        SettingsRepository $settingsRepository,
        OperatorsWorkRepository $operatorsWorkRepository
    ) {
        $this->templatingEngine         = $templatingEngine;
        $this->translator               = $translator;
        $this->applicationContext       = $applicationContext;
        $this->modelsRepository         = $modelsRepository;
        $this->operationsRepository     = $operationsRepository;
        $this->operatorsRepository      = $operatorsRepository;
        $this->settingsRepository       = $settingsRepository;
        $this->operatorsWorkRepository  = $operatorsWorkRepository;
    }
    
    public function updateModels( Request $request ): JsonResponse
    {
        $em     = $this->getDoctrine()->getManager();
        $form   = $this->createForm( ModelsIndexForm::class, ['models' => $this->getModels()] );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $models          = $form->get( 'models' )->getData();
            $submitedModels  = $request->get( 'submitedModels' );
            if ( is_array( $submitedModels ) ) {
                foreach( array_keys( $submitedModels ) as $modelId ) {
                    $em->persist( $models[$modelId] );
                }
                $em->flush();
            }
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
    
    public function deleteModels( Request $request ): JsonResponse
    {
        $em     = $this->getDoctrine()->getManager();
        $form   = $this->createForm( ModelsIndexForm::class, ['models' => $this->getModels()] );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $models          = $form->get( 'models' )->getData();
            $submitedModels  = $request->get( 'submitedModels' );
            if ( is_array( $submitedModels ) ) {
                foreach( array_keys( $submitedModels ) as $modelId ) {
                    $models[$modelId]->setDeletedBy( $this->getUser() );
                    $em->persist( $models[$modelId] );
                    $em->flush(); // Need Flush() to save deleted_by_id field
                    
                    $em->remove( $models[$modelId] );
                }
                $em->flush();
            }
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
    
    public function jsonListModels( Request $request ): JsonResponse
    {
        $listModels = $this->modelsRepository->findAll();
        
        $aaModels   = [];
        foreach( $listModels as $m ) {
            $aaModels[] = array(
                'label' => $m->getNumber().'. '.$m->getName(),
                'value' => $m->getId()
            );
            
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK, 
            'data'      => $aaModels,  
        ]);
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
        
        $tplVars = [
            'model'             => $model,
            'operators'         => $operators,
            'settings'          => $settings,
            'date'              => $date,
            'operatorsWork'     => $operatorsWork,
            'workCount'         => $this->getOperatorsWorkCount( $operatorsWork['listOperations'], $date )
        ];
        
        return $this->render( 'pages/Models/operators_work.html.twig', $tplVars );
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
    
    private function getModels(): array
    {
        $models = $this->modelsRepository->findAll();
        $modelsIndexed = [];
        foreach ( $models as $mod ) {
            $modelsIndexed[$mod->getId()] = $mod;
        }
        
        return $modelsIndexed;
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
