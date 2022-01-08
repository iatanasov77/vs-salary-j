<?php namespace App\Controller\SalaryJ;

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
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $this->currentRequest );
        $form           = $this->resourceFormFactory->create( $configuration, $this->getFactory()->createNew() );
        
        $filterGroup    = $request->query->get( 'group' );
        if ( empty( $filterGroup ) )
            $filterGroup    = null;
        
        $operators  = $this->get( 'salaryj.repository.operators' )->findBy( ['group' => $filterGroup] );
        $operatorsIndexed = [];
        foreach ( $operators as $op ) {
            $operatorsIndexed[$op->getId()] = $op;
        }
        
        return [
            'application'   => $this->get( 'vs_application.context.application' )->getApplication(),
            'form'          => $form->createView(),
            'filter_form'   => $this->createForm( OperatorFilterForm::class )->createView(),
            'filter_value'  => $request->query->get( 'group' ),
            'index_form'    =>  $this->createForm( OperatorsIndexForm::class, ['operators' => $operatorsIndexed] )->createView(),
            'operators'     => $operatorsIndexed,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $ogr        = $this->get( 'salaryj.repository.operatorsgroups' );
        $formPost   = $request->request->get( 'operator_form' );
        $group      = $ogr->find( $formPost['operator']['group'] );
        
        $entity->setApplication( $this->get( 'vs_application.context.application' )->getApplication() );
        $entity->setGroup( $group );
        $entity->setName( $formPost['operator']['name'] );
        if ( $entity->getId() ) {
            $entity->setUpdatedBy( $this->getUser() );
        } else {
            $entity->setCreatedBy( $this->getUser() );
        }
    }
}
