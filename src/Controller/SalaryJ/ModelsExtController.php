<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ModelsExtController extends AbstractController
{
    private $modelsRepository;
    
    public function __construct( EntityRepository $modelsRepository )
    {
        $this->modelsRepository  = $modelsRepository;
    }
    
    public function jsonListModels( Request $request ) : Response
    {
        $listModels = $this->modelsRepository->findAll();
        
        $aaModels   = [];
        foreach( $listModels as $m ) {
            $aaModels[] = array(
                'label' => $m->getNumber().'. '.$m->getName(),
                'value' => $m->getId()
            );
            
        }
        
        return new JsonResponse([
            'status'    => 'ok', 
            'data'      => $aaModels,  
        ]);
    }
    
    public function browseOperations( int $modelId, Request $request ) : Response
    {
        $tplVars = [
            
        ];
        
        return $this->render( 'salary-j/pages/Operations/model_browse_operations.html.twig', $tplVars );
    }
    
    public function browseOperationsGet( Request $request ) : Response
    {
        return $this->browseOperations( $request->query->get( 'modid' ), $request );
    }
    
    public function addOperations( int $modelId, Request $request ) : Response
    {
        $tplVars = [
            
        ];
        
        return $this->render( 'salary-j/pages/Operations/model_add_operations.html.twig', $tplVars );
    }
    
    public function addOperationsNew( int $modelId, Request $request ) : Response
    {
        $tplVars = [
            
        ];
        
        return $this->render( 'salary-j/pages/Operations/model_add_operations.html.twig', $tplVars );
    }
}
