<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OperatorsGroupsController extends AbstractController
{
    public function index( Request $request ) : Response
    {
        return $this->render( 'salary-j/pages/home.html.twig' );
    }
}
