<?php namespace App\Controller\SalaryJ;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

class ModelsController extends AbstractCrudController
{
    protected function customData( Request $request, $entity = NULL ) : array
    {
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $this->currentRequest );
        $form           = $this->resourceFormFactory->create( $configuration, $this->getFactory()->createNew() );
            
        $models         = $this->get( 'salaryj.repository.models' )->findAll();
            
        return [
            'application'   => $this->get( 'vs_application.context.application' )->getApplication(),
            'form'          => $form->createView(),
            
            'models'        => $models,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        
    }
}
