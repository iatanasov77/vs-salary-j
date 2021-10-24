<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OperatorsWorkController extends AbstractController
{
    public function browseOperations( int $operatorId, Request $request ) : Response
    { 
        $tplVars = [
            
        ];
        
        return $this->render( 'salary-j/pages/OperatorsWork/index.html.twig', $tplVars );
    }
}
