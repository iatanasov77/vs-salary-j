<?php namespace App\Controller\SalaryJ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Sylius\Component\Resource\Factory\Factory;

use Vankosoft\ApplicationBundle\Component\Context\ApplicationContextInterface;

use App\Entity\Settings;
use App\Repository\SettingsRepository;

class SettingsController extends AbstractController
{
    /** @var ApplicationContextInterface */
    private $applicationContext;
    
    /** @var SettingsRepository */
    private $repository;
    
    /** @var Factory */
    private $factory;
    
    public function __construct(
        ApplicationContextInterface $applicationContext,
        SettingsRepository $repository,
        Factory $factory  
    ) {
        $this->applicationContext   = $applicationContext;
        $this->repository           = $repository;
        $this->factory              = $factory;
    }
    
    public function index( Request $request ) : Response
    {
        $application    = $this->applicationContext->getApplication();
        $settings       = $this->repository ->getSettings( $application->getId() );
        
        return $this->render( 'pages/Settings/index.html.twig', [
            'settings'  => $settings,
            'form'      => $this->createSettingsForm( $settings )->createView(),
        ]);
    }
    
    public function update( Request $request ) : Response
    {
        $application    = $this->applicationContext->getApplication();
        $settings       = $this->repository ->getSettings( $application->getId() );
        $form           = $this->createSettingsForm( $settings );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $em     = $this->getDoctrine()->getManager();
            $data   = $form->getData();
            foreach ( $data as $key => $val ) {
                if ( $settings[$key]['status'] == SettingsRepository::STATUS_NOT_SAVED ) {
                    $entity = $this->factory->createNew();
                    
                    $entity->setApplication( $application );
                    $entity->setVarName( $key );
                } else {
                    $entity = $this->repository->findOneBy( ['application' => $application, 'varName' => $key] );
                }

                $entity->setVarValue( $val );
                $em->persist( $entity );
            }
            $em->flush();
            
            return $this->redirect( $this->generateUrl( 'salaryj_settings_index' ) );
        }
        
        return new Response( 'The form is not hanled properly !!!', Response::HTTP_BAD_REQUEST );
    }
    
    private function createSettingsForm( $settings )
    {
        $fb             = $this->createFormBuilder();
        foreach ( $settings as $key => $val ) {
            $fb->add( $key, TextType::class, [
                'label'                 => $val['label'],
                'translation_domain'    => 'SalaryJ',
            ]);
        }
        
        return $fb->add( 'save', SubmitType::class, [
            'label' => 'salary-j.form.save',
            'translation_domain' => 'SalaryJ'
        ])->getForm();
    }
}
