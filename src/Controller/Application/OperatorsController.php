<?php namespace App\Controller\Application;

use Symfony\Component\HttpFoundation\Request;
use Sylius\Component\Resource\ResourceActions;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

use App\Form\OperatorFilterForm;
use App\Form\OperatorsIndexForm;
use App\Form\Type\OperatorType;

class OperatorsController extends AbstractCrudController
{
    protected function customData( Request $request, $entity = NULL ) : array
    {
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $request );
        $form           = $this->resourceFormFactory->create( $configuration, $this->getFactory()->createNew() );
        
        $operatorsIndexed = [];
        if ( $this->resources ) {
            foreach ( $this->resources as $op ) {
                if ( $op->getDeletedAt() ) {
                    continue;
                }
                $operatorsIndexed[$op->getId()] = $op;
            }
            //var_dump( $operatorsIndexed ); die;
        }
        
        $indexForm  = $this->createForm( OperatorsIndexForm::class, ['operators' => $operatorsIndexed], [
            'action'                => $this->generateUrl( 'app_operators_ext_update' ),
            'method'                => 'POST',
            'operatorsResources'    => $operatorsIndexed
        ]);
        
        return [
            'application'   => $this->get( 'vs_application.context.application' )->getApplication(),
            'form'          => $form->createView(),
            'filter_form'   => $this->createForm( OperatorFilterForm::class )->createView(),
            'filter_value'  => $request->attributes->get( 'groupId' ),
            'index_form'    => $indexForm->createView(),
            'operators'     => $operatorsIndexed,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $currentUser    = $this->get( 'vs_users.security_bridge' )->getUser();
        $ogr            = $this->get( 'salaryj.repository.operatorsgroups' );
        $formPost       = $request->request->all( 'operator_form' );
        $group          = $ogr->find( $formPost['operator']['group'] );
        
        $entity->setApplication( $this->get( 'vs_application.context.application' )->getApplication() );
        $entity->setGroup( $group );
        $entity->setName( $formPost['operator']['name'] );
        if ( $entity->getId() ) {
            $entity->setUpdatedBy( $currentUser );
        } else {
            $entity->setCreatedBy( $currentUser );
        }
    }
}
