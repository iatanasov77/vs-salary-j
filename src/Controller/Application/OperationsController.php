<?php namespace App\Controller\Application;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

use App\Form\OperationsIndexForm;

class OperationsController extends AbstractCrudController
{
    protected function customData( Request $request, $entity = NULL ): array
    {
        $application    = $this->get( 'vs_application.context.application' )->getApplication();
        $modelId        = $request->attributes->get( 'modelId' );
        $model          = $this->get( 'salaryj.repository.models' )->find( $modelId );
        $settings       = $this->get( 'salaryj.repository.settings' )->getSettings( $application->getId() );
        $totals         = $this->repository->getTotals( $model );
        
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $request );
        $form           = $this->resourceFormFactory->create( $configuration, $this->getFactory()->createNew() );
        
        $operationsIndexed = [];
        foreach ( $model->getOperations() as $op ) {
            $operationsIndexed[$op->getId()] = $op;
        }
        $indexForm      = $this->createForm( OperationsIndexForm::class, ['operations' => $operationsIndexed], [
            //'action'    => $this->generateUrl( 'app_model_operations_save_operations', ['modelId' => $modelId] ),
            'method'    => 'POST',
        ]);
        
        return [
            'application'   => $application,
            'model'         => $model,
            'operationForm' => $form->createView(),
            'settings'      => $settings,
            'totals'        => $totals,
            'index_form'    => $indexForm->createView(),
            'operations'    => $operationsIndexed,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $currentUser        = $this->get( 'vs_users.security_bridge' )->getUser();
        $applicationContext = $this->get( 'vs_application.context.application' );
        
        $entity->setApplication( $applicationContext->getApplication() );
        if ( $entity->getId() ) {
            $entity->setUpdatedBy( $currentUser );
        } else {
            $entity->setCreatedBy( $currentUser );
        }
    }
}
