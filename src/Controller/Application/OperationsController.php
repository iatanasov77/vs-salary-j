<?php namespace App\Controller\Application;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

class OperationsController extends AbstractCrudController
{
    protected function customData( Request $request, $entity = NULL ) : array
    { 
        return [];
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
