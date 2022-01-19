<?php namespace App\Controller\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

use Vankosoft\ApplicationBundle\Component\Context\ApplicationContextInterface;

class DefaultController extends AbstractController
{
    /** @var ApplicationContextInterface */
    private $applicationContext;
    
    /** @var Environment */
    private $templatingEngine;
    
    public function __construct(
        ApplicationContextInterface $applicationContext,
        Environment $templatingEngine
    ) {
            $this->applicationContext   = $applicationContext;
            $this->templatingEngine     = $templatingEngine;
    }
    
//     public function index( Request $request ): Response
//     {
//         return new Response( $this->templatingEngine->render( $this->getTemplate(), [] ) );
//     }
    public function index( Request $request ): Response
    {
        return $this->redirect( $this->generateUrl( 'salaryj_operators_index', ['groupId' => 1] ) );
    }
    
    protected function getTemplate(): string
    {
        $template   = 'pages/Dashboard/index.html.twig';
        
        $appSettings    = $this->applicationContext->getApplication()->getSettings();
        if ( ! $appSettings->isEmpty() && $appSettings[0]->getTheme() ) {
            $template   = 'pages/Dashboard/index.html.twig';
        }
        
        return $template;
    }
}
