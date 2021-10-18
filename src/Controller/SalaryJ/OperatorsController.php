<?php namespace App\Controller\SalaryJ;

use Symfony\Component\HttpFoundation\Request;
use VS\ApplicationBundle\Controller\AbstractCrudController;

class OperatorsController extends AbstractCrudController
{
    protected function customData() : array
    { 
        $taxonomy   = $this->get( 'vs_application.repository.taxonomy' )->findByCode(
            $this->getParameter( 'salary_j.operators_groups.taxonomy_code' )
        );
        
        return [
            'operatorsGroups'   => $this->get( 'salaryj.repository.operatorsgroups' )->findAll(),
            'taxonomyId'        => $taxonomy ? $taxonomy->getId() : 0,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $pcr        = $this->get( 'vs_cms.repository.page_categories' );
        $formPost   = $request->request->get( 'page_form' );
        
        if ( isset( $formPost['category_taxon'] ) ) {
            foreach ( $formPost['category_taxon'] as $taxonId ) {
                $category       = $pcr->findOneBy( ['taxon' => $taxonId] );
                if ( $category ) {
                    $categories[]   = $category;
                    $entity->addCategory( $category );
                }
            }
            
            foreach ( $entity->getCategories() as $cat ) {
                if ( ! $categories->contains( $cat ) ) {
                    $entity->removeCategory( $cat );
                }
            }
        }
    }
}
