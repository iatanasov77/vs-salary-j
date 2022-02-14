<?php namespace App\Controller\Application;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

use App\Form\OperationsIndexForm;

class OperationsController extends AbstractCrudController
{
    protected function customData( Request $request, $entity = NULL ): array
    {
        $application    = $this->get( 'vs_application.context.application' )->getApplication();
        $model          = $this->get( 'salaryj.repository.models' )->find( $request->attributes->get( 'modelId' ) );
        $settings       = $this->get( 'salaryj.repository.settings' )->getSettings( $application->getId() );
        $totals         = $this->repository->getTotals( $model );
        
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $this->currentRequest );
        $form           = $this->resourceFormFactory->create( $configuration, $this->getFactory()->createNew() );
        
        $operationsIndexed = [];
        foreach ( $this->resources as $op ) {
            $operationsIndexed[$op->getId()] = $op;
        }
        
        return [
            'application'   => $application,
            'model'         => $model,
            'operationForm' => $form->createView(),
            'settings'      => $settings,
            'totals'        => $totals,
            'index_form'    => $this->createForm( OperationsIndexForm::class, ['operations' => $operationsIndexed] )->createView(),
            'operations'     => $operationsIndexed,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $currentUser        = $this->getUser();
        $applicationContext = $this->get( 'vs_application.context.application' );
        
        $entity->setApplication( $applicationContext->getApplication() );
        if ( $entity->getId() ) {
            $entity->setUpdatedBy( $currentUser );
        } else {
            $entity->setCreatedBy( $currentUser );
        }
    }
}
