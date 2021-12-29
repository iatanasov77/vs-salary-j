<?php namespace App\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use App\Entity\Operation;

class OperationsRepository extends EntityRepository
{
    public function getTotals( $model ) : array
    {
        $totals = $this->createQueryBuilder( 'op' )
                        ->andWhere( 'op.model = :model' )
                        ->setParameter( 'model', $model )
                        ->select( ['SUM(op.minutes) as totalMinutes', 'SUM(op.price) as totalPrice'] )
                        ->getQuery()
                        ->getScalarResult();
        
        if ( $totals ) {
            $totals = [
                "totalMinutes"  => (float)$totals[0]["totalMinutes"],
                "totalPrice"    => (float)$totals[0]["totalPrice"],
            ];
        } else {
            $totals = [
                "totalMinutes"  => 0,
                "totalPrice"    => 0
            ];
        }
        
        //var_dump($totals); die;
        return $totals;
    }
}
