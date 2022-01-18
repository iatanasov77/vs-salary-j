<?php namespace App\Controller\Application;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

use App\Form\ModelsIndexForm;

class ModelsController extends AbstractCrudController
{
    protected function customData( Request $request, $entity = NULL ) : array
    {
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $this->currentRequest );
        $form           = $this->resourceFormFactory->create( $configuration, $this->getFactory()->createNew() );
        
        $modelsIndexed  = [];
        foreach ( $this->resources as $mod ) {
            $modelsIndexed[$mod->getId()] = $mod;
        }
        
        return [
            'application'   => $this->get( 'vs_application.context.application' )->getApplication(),
            'form'          => $form->createView(),
            'index_form'    =>  $this->createForm( ModelsIndexForm::class, ['models' => $modelsIndexed] )->createView(),
            'models'        => $modelsIndexed,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $currentUser        = $this->getUser();
        $applicationContext = $this->get( 'vs_application.context.application' );
        $formPost           = $request->request->get( 'model_form' );
        
        $entity->setApplication( $applicationContext->getApplication() );
        $entity->setNumber( $formPost['model']['number'] );
        $entity->setName( $formPost['model']['name'] );
        if ( $entity->getId() ) {
            $entity->setUpdatedBy( $currentUser );
        } else {
            $entity->setCreatedBy( $currentUser );
        }
    }
}
