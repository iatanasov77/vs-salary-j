<?php namespace App\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Doctrine\ORM\AbstractQuery;

/**
 * MANUALS USING VIEWS:
 * --------------------
 *  https://stackoverflow.com/questions/8377671/how-to-set-up-entity-doctrine-for-database-view-in-symfony-2
 *  https://robbert.rocks/aggregate-your-data-by-using-sql-views-and-doctrine
 */
class OperatorsWorkRepository extends EntityRepository
{
    public function getWorkForOperator( $operator, $startDate, $endDate ) : array
    {
        $work   = $this->findBy([
            'operator'  => $operator,
        ]);

        return $work;
    }
    
    /**
     * @NOTE Need Optimization and Refactoring
     * Got from JunObjectsFactory::makeOperationsWorkCount
     * 
     * @param unknown $modelId
     * @param unknown $minDate
     * @param unknown $maxDate
     * @param boolean $groupOperations
     * @return unknown[]|number[][]|NULL[][]
     */
    function getOperationsWorkCount( $modelId, $minDate, $maxDate, $groupOperations = true )
    {
        $entityManager  = $this->getEntityManager();
        $qb             = $entityManager->createQueryBuilder( 'owt' )
                                ->select( 'owt' )
                                ->from( 'App\Entity\OperatorsWorkTotals', 'owt' )
                                ->andWhere( 'owt.modelId = :modelId' )
                                ->andWhere( 'owt.date >= :minDate' )
                                ->andWhere( 'owt.date <= :maxDate' )
                                ->setParameter( 'modelId', $modelId )
                                ->setParameter( 'minDate', $minDate )
                                ->setParameter( 'maxDate', $maxDate );
        
        if( $groupOperations ) {
            $qb->select( ['SUM(owt.count) AS sum_count', 'SUM(owt.total) AS sum_total'] )
                ->groupBy( 'owt.operationId' )
                ->orderBy( 'CAST(owt.operationNumber AS UNSIGNED)', 'DESC' );
        }
        
        $query                  = $qb->getQuery();
        $listOperations         = [];
        $grandTotal             = 0;
        $operationsTotalCount   = [];
        
        //echo"<pre>"; var_dump( $query->getResult( AbstractQuery::HYDRATE_ARRAY ) ); die;
        foreach ( $query->getResult( AbstractQuery::HYDRATE_ARRAY ) as $owt ) {
            if( ! isset($operationsTotalCount[$owt['operationId']] ) ) {
                $operationsTotalCount[$owt['operationId']] = 0;
            }
            
            if( $groupOperations ) {
                $operationsTotalCount[$owt['operationId']] += $owt['sum_count'];
                $grandTotal += $owt->sum_total;
            }
            else {
                $operationsTotalCount[$owt['operationId']] += $owt['count'];
                $grandTotal += $owt['total'];
            }
            
            $listOperations[] = $owt;
        }
        
        return [
            'listOperations'        => $listOperations,
            'grandTotal'            => $grandTotal,
            'operationsTotalCount'  => $operationsTotalCount,
        ];
    }
}
