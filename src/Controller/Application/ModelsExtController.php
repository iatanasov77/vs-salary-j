<?php namespace App\Controller\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    /** @var ManagerRegistry */
    private $doctrine;
    
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
        ManagerRegistry $doctrine,
        Environment $templatingEngine,
        TranslatorInterface $translator,
        ApplicationContext $applicationContext,
        EntityRepository $modelsRepository,
        OperationsRepository $operationsRepository,
        EntityRepository $operatorsRepository,
        SettingsRepository $settingsRepository,
        OperatorsWorkRepository $operatorsWorkRepository
    ) {
        $this->doctrine                 = $doctrine;
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
        $em     = $this->doctrine->getManager();
        $form   = $this->createForm( ModelsIndexForm::class );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $models         = $form->get( 'models' )->getData();
            $submitedModels = $request->get( 'submitedModels' );
            //var_dump( \array_keys( $submitedModels ) ); die;
            
            if ( is_array( $submitedModels ) ) {
                foreach( array_keys( $submitedModels ) as $modelId ) {
                    $model  = $this->modelsRepository->find( $modelId );
                    
                    $model->setNumber( $models[$modelId]->getNumber() );
                    $model->setName( $models[$modelId]->getName() );
                    $em->persist( $model );
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
        $em     = $this->doctrine->getManager();
        $form   = $this->createForm( ModelsIndexForm::class );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $submitedModels  = $request->get( 'submitedModels' );
            if ( is_array( $submitedModels ) ) {
                foreach( array_keys( $submitedModels ) as $modelId ) {
                    $model  = $this->modelsRepository->find( $modelId );
                    
                    $model->setDeletedBy( $this->getUser() );
                    $em->persist( $model  );
                    $em->flush(); // Need Flush() to save deleted_by_id field
                    $em->remove( $model  );
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
        $listModels = $this->modelsRepository->findBy(['application' => $this->applicationContext->getApplication()]);
        
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
