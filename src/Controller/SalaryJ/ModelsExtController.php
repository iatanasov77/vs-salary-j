<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use VS\ApplicationBundle\Component\Context\ApplicationContext;

use App\Form\OperationForm;
use App\Repository\OperationsRepository;
use App\Repository\SettingsRepository;

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
    
    public function __construct(
        ApplicationContext $applicationContext,
        EntityRepository $modelsRepository,
        OperationsRepository $operationsRepository,
        EntityRepository $operatorsRepository,
        SettingsRepository $settingsRepository
    ) {
        $this->applicationContext   = $applicationContext;
        $this->modelsRepository     = $modelsRepository;
        $this->operationsRepository = $operationsRepository;
        $this->operatorsRepository  = $operatorsRepository;
        $this->settingsRepository   = $settingsRepository;
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
    
    public function addOperationsNew( int $modelId, $operatorsGroupId, Request $request ) : Response
    {
        $model          = $this->modelsRepository->find( $modelId );
        $operators      = $this->operatorsRepository->findBy( ['group' => $operatorsGroupId ?: null] );
        
        $tplVars = [
            'model'     => $model,
            'operators' => $operators,
        ];
        
        return $this->render( 'salary-j/pages/Models/operators_work.html.twig', $tplVars );
    }
}
