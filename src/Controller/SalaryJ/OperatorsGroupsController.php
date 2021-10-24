<?php namespace App\Controller\SalaryJ;

use Symfony\Component\HttpFoundation\Request;
use VS\ApplicationBundle\Controller\AbstractCrudController;
use VS\ApplicationBundle\Controller\TaxonomyHelperTrait;

class OperatorsGroupsController extends AbstractCrudController
{
    use TaxonomyHelperTrait;
    
    protected function customData(): array
    {
        $taxonomy   = $this->get( 'vs_application.repository.taxonomy' )->findByCode(
            $this->getParameter( 'salary_j.operators_groups.taxonomy_code' )
        );
        
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $this->currentRequest );
        $form           = $this->resourceFormFactory->create( $configuration, $this->getFactory()->createNew() );
        
        return [
            'application'   => $this->get( 'vs_application.context.application' )->getApplication(),
            'form'          => $form->createView(),
            'taxonomy'      => $taxonomy,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $translatableLocale = $form['currentLocale']->getData();
        $categoryName       = $form['name']->getData();
        /*
        $parentGroup        = $this->get( 'salaryj.repository.operatorsgroups' )
                                    ->findByTaxonId( $_POST['operators_group_form']['parent'] );
        */
        $parentGroup        = null;
        
        $entity->setApplication( $this->get( 'vs_application.context.application' )->getApplication() );
        if ( $entity->getTaxon() ) {
            $entity->getTaxon()->setCurrentLocale( $translatableLocale );
            $entity->getTaxon()->setName( $categoryName );
            if ( $parentGroup ) {
                $entity->getTaxon()->setParent( $parentGroup->getTaxon() );
            }
            
            $entity->setParent( $parentGroup );
        } else {
            /*
             * @WORKAROUND Create Taxon If not exists
             */
            $taxonomy   = $this->get( 'vs_application.repository.taxonomy' )->findByCode(
                $this->getParameter( 'salary_j.operators_groups.taxonomy_code' )
            );
            $newTaxon   = $this->createTaxon(
                $categoryName,
                $translatableLocale,
                $parentGroup ? $parentGroup->getTaxon() : null,
                $taxonomy->getId()
            );
            
            $entity->setTaxon( $newTaxon );
            $entity->setParent( $parentGroup );
        }
    }
}
