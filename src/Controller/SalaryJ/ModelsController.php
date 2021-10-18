<?php namespace App\Controller\SalaryJ;

use Symfony\Component\HttpFoundation\Request;
use VS\ApplicationBundle\Controller\AbstractCrudController;

class ModelsController extends AbstractCrudController
{
    protected function customData() : array
    { 
        return [];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        
    }
}
