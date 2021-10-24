<?php namespace App\Controller\SalaryJ;

use Symfony\Component\HttpFoundation\Request;
use VS\ApplicationBundle\Controller\AbstractCrudController;

class OperationsController extends AbstractCrudController
{
    protected function customData( Request $request ) : array
    { 
        return [];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        
    }
}
