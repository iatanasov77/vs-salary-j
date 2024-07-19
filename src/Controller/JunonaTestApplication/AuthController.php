<?php namespace App\Controller\JunonaTestApplication;

use App\Controller\Application\AuthController as ApplicationAuthController;
use Twig\Environment;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContextInterface;

class AuthController extends ApplicationAuthController
{
    public function __construct(
        ApplicationContextInterface $applicationContext,
        Environment $templatingEngine
    ) {
        parent::__construct( $applicationContext, $templatingEngine );
        
        $this->applicationRole  = 'ROLE_JUNONA_STARA_ZAGORA_ADMIN';
    }
    
}
