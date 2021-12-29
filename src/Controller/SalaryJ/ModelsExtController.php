<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;

use App\Form\OperationForm;
use App\Repository\OperationsRepository;
use App\Repository\SettingsRepository;
use App\Repository\OperatorsWorkRepository;

class ModelsExtController extends AbstractController
{
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
        ApplicationContext $applicationContext,
        EntityRepository $modelsRepository,
        OperationsRepository $operationsRepository,
        EntityRepository $operatorsRepository,
        SettingsRepository $settingsRepository,
        OperatorsWorkRepository $operatorsWorkRepository
    ) {
        $this->applicationContext       = $applicationContext;
        $this->modelsRepository         = $modelsRepository;
        $this->operationsRepository     = $operationsRepository;
        $this->operatorsRepository      = $operatorsRepository;
        $this->settingsRepository       = $settingsRepository;
        $this->operatorsWorkRepository  = $operatorsWorkRepository;
    }
    
    public function jsonListModels( Request $request ) : Response
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
            'status'    => 'ok', 
            'data'      => $aaModels,  
        ]);
    }
    
    public function browseOperations( int $modelId, Request $request ) : Response
    {
        $model          = $this->modelsRepository->find( $modelId );
        $operationForm  = $this->createForm( OperationForm::class );
        $settings       = $this->settingsRepository->getSettings( $this->applicationContext->getApplication()->getId() );
        $totals         = $this->operationsRepository->getTotals( $model );
        //var_dump($settings); die;
        
        $tplVars = [
            'model'         => $model,
            'operationForm' => $operationForm->createView(),
            'settings'      => $settings,
            'totals'        => $totals,
        ];
        
        return $this->render( 'salary-j/pages/Operations/model_browse_operations.html.twig', $tplVars );
    }
    
    public function browseOperationsGet( Request $request ) : Response
    {
        return $this->browseOperations( $request->query->get( 'modid' ), $request );
    }
    
    public function addOperations( int $modelId, Request $request ) : Response
    {
        $tplVars = [
            
        ];
        
        return $this->render( 'salary-j/pages/Operations/model_add_operations.html.twig', $tplVars );
    }
    
    public function addOperationsNew( int $modelId, Request $request ) : Response
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
            'workCount'         => $this->getWorkCount( $operatorsWork['listOperations'], $date )
        ];
        
        return $this->render( 'salary-j/pages/Models/operators_work.html.twig', $tplVars );
    }
    
    private function getWorkCount( $workedOperations, $date )
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
}
