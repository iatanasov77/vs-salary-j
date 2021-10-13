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
            $this->getParameter( 'vs_application.page_categories.taxonomy_code' )
        );
        
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $this->currentRequest );
        $form           = $this->resourceFormFactory->create( $configuration, $this->getFactory()->createNew() );
        
        return [
            'taxonomyId'    => $taxonomy ? $taxonomy->getId() : 0,
            'form'          => $form->createView(),
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $translatableLocale = $form['currentLocale']->getData();
        $categoryName       = $form['name']->getData();
        $parentGroup        = $this->get( 'salaryj.repository.operatorsgroups' )
                                    ->findByTaxonId( $_POST['operators_group_form']['parent'] );
        
        if ( $entity->getTaxon() ) {
            $entity->getTaxon()->setCurrentLocale( $translatableLocale );
            $entity->getTaxon()->setName( $categoryName );
            if ( $parentCategory ) {
                $entity->getTaxon()->setParent( $parentCategory->getTaxon() );
            }
            
            $entity->setParent( $parentCategory );
        } else {
            /*
             * @WORKAROUND Create Taxon If not exists
             */
            $taxonomy   = $this->get( 'vs_application.repository.taxonomy' )->findByCode(
                $this->getParameter( 'vs_application.page_categories.taxonomy_code' )
                );
            $newTaxon   = $this->createTaxon(
                $categoryName,
                $translatableLocale,
                $parentCategory ? $parentCategory->getTaxon() : null,
                $taxonomy->getId()
                );
            
            $entity->setTaxon( $newTaxon );
            $entity->setParent( $parentCategory );
        }
    }
}
