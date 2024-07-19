<?php namespace App\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface;

class ModelsRepository extends EntityRepository
{
    public function getQueryBuilder( ApplicationInterface $application, string $alias ): QueryBuilder
    {
        $qb = $this->createQueryBuilder( $alias )
                    ->where( \sprintf( '%s.application = :application', $alias ) )
                    ->setParameter( 'application', $application );
        
        return $qb;
    }
}
