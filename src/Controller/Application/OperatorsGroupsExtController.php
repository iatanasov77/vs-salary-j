<?php namespace App\Controller\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;
use Vankosoft\ApplicationBundle\Component\SlugGenerator;
use Vankosoft\ApplicationBundle\Component\Status;
use App\Form\OperatorsGroupsIndexForm;

class OperatorsGroupsExtController extends AbstractController
{
    /** @var ApplicationContext */
    private $applicationContext;
    
    /** @var EntityRepository */
    private $groupsRepository;
    
    /** @var SlugGenerator */
    private $slugGenerator;
    
    public function __construct(
        ApplicationContext $applicationContext,
        EntityRepository $groupsRepository,
        SlugGenerator $slugGenerator
    ) {
        $this->applicationContext       = $applicationContext;
        $this->groupsRepository         = $groupsRepository;
        $this->slugGenerator            = $slugGenerator;
    }
    
    public function updateGroups( Request $request ): JsonResponse
    {
        $em     = $this->getDoctrine()->getManager();
        $form   = $this->createForm( OperatorsGroupsIndexForm::class, ['operators_groups' => $this->getGroups()] );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $groups          = $form->get( 'operators_groups' )->getData();
            $submitedGroups  = $request->get( 'grids' );
            if ( is_array( $submitedGroups ) ) {
                foreach( array_keys( $submitedGroups ) as $groupId ) {
                    $groups[$groupId]->getTaxon()->setCurrentLocale( $request->getLocale() );
                    $groups[$groupId]->getTaxon()->setName( $groups[$groupId]->getName() );
                    $groups[$groupId]->getTaxon()->setCode( $this->slugGenerator->generate( $groups[$groupId]->getName() ) );
                    
                    $em->persist( $groups[$groupId] );
                }
                $em->flush();
            }
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
    
    public function deleteGroups( Request $request ): JsonResponse
    {
        $em     = $this->getDoctrine()->getManager();
        $form   = $this->createForm( OperatorsGroupsIndexForm::class, ['operators_groups' => $this->getGroups()] );
        
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $groups          = $form->get( 'operators_groups' )->getData();
            $submitedGroups  = $request->get( 'grids' );
            if ( is_array( $submitedGroups ) ) {
                foreach( array_keys( $submitedGroups ) as $groupId ) {
                    $groups[$groupId]->setDeletedBy( $this->getUser() );
                    $groups[$groupId]->setDeletedAt( new \DateTime() );
                    
                    // Taxons are not SoftDeletable
                    $em->remove( $groups[$groupId]->getTaxon() );
                    
                    $em->persist( $groups[$groupId] );
                }
                $em->flush();
            }
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
    
    private function getGroups(): array
    {
        $groups = $this->groupsRepository->findAll();
        $groupsIndexed = [];
        foreach ( $groups as $gr ) {
            $groupsIndexed[$gr->getId()] = $gr;
        }
        
        return $groupsIndexed;
    }
}
