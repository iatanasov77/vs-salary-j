<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    public function login( AuthenticationUtils $authenticationUtils ): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        //var_dump($error); die;
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $tplVars = array(
            'last_username' => $lastUsername,
            'error'         => $error,
        );
        
        return $this->render( 'salary-j/pages/login.html.twig', $tplVars );
    }
    
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception( 'Don\'t forget to activate logout in security.yaml' );
    }
}

