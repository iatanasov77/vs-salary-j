<?php namespace App\Controller\SalaryJ;

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
        
    }
}
