<?php namespace App\Controller\Application;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;
use Vankosoft\ApplicationBundle\Controller\TaxonomyHelperTrait;

use App\Form\OperatorsGroupsIndexForm;

class OperatorsGroupsController extends AbstractCrudController
{
    use TaxonomyHelperTrait;
    
    protected function customData( Request $request, $entity = NULL ): array
    {        
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $this->currentRequest );
        $form           = $this->resourceFormFactory->create( $configuration, $this->getFactory()->createNew() );
        
        $groupsIndexed = [];
        foreach ( $this->resources as $gr ) {
            $groupsIndexed[$gr->getId()] = $gr;
        }
        
        return [
            'application'   => $this->get( 'vs_application.context.application' )->getApplication(),
            'form'          => $form->createView(),
            'index_form'    => $this->createForm( OperatorsGroupsIndexForm::class, ['operators_groups' => $groupsIndexed] )->createView(),
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $translatableLocale = $form['currentLocale']->getData();
        $categoryName       = $form['operator_group']['name']->getData();
        /*
        $parentGroup        = $this->get( 'salaryj.repository.operatorsgroups' )
                                    ->findByTaxonId( $_POST['operators_group_form']['parent'] );
        */
        $parentGroup        = null;
        
        $entity->setApplication( $this->get( 'vs_application.context.application' )->getApplication() );
        $entity->setName( $categoryName );
        
        if ( $entity->getTaxon() ) {
            $entityTaxon    = $entity->getTaxon();
            
            $entityTaxon->setCurrentLocale( $translatableLocale );
            $entityTaxon->setName( $categoryName );
            $entityTaxon->setCode( $this->get( 'vs_application.slug_generator' )->generate( $categoryName ) );
            
            if ( $parentGroup ) {
                $entityTaxon->setParent( $parentGroup->getTaxon() );
            }
        } else {
            $taxonomy   = $this->get( 'vs_application.repository.taxonomy' )->findByCode(
                $this->getParameter( 'salary_j.operators_groups.taxonomy_code' )
            );
            $entityTaxon    = $this->createTaxon(
                $categoryName,
                $translatableLocale,
                $parentGroup ? $parentGroup->getTaxon() : null,
                $taxonomy->getId()
            );
        }
        
        $entity->setTaxon( $entityTaxon );
        $entity->setParent( $parentGroup );
    }
}
