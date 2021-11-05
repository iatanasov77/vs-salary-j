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
    public function getWorkForOperator( $operator, $startDate, $endDate, $groupOperations = false ) : array
    {
        $entityManager  = $this->getEntityManager();
        $qb             = $entityManager->createQueryBuilder( 'owt' )
                                        ->select( 'owt' )
                                        ->from( 'App\Entity\OperatorsWorkTotals', 'owt' )
                                        ->andWhere( 'owt.operatorId = :operatorId' )
                                        ->andWhere( 'owt.date >= :minDate' )
                                        ->andWhere( 'owt.date <= :maxDate' )
                                        ->setParameter( 'operatorId', $operator->getId() )
                                        ->setParameter( 'minDate', $startDate )
                                        ->setParameter( 'maxDate', $endDate );
        
        if( $groupOperations ) {
            $qb->select( $this->groupOperationsSelect() )
                ->groupBy( 'owt.operationId' )
                //->orderBy( 'CAST(owt.operationNumber AS UNSIGNED)', 'DESC' );
                ->orderBy( 'owt.operationNumber', 'DESC' );
        }
        
        $query                  = $qb->getQuery();
        $listOperations         = [];
        $grandTotal             = 0;
        $operationsTotalCount   = [];

        //$this->debugQuery( $query );
        foreach ( $query->getResult( AbstractQuery::HYDRATE_ARRAY ) as $owt ) {
            //echo "<pre>"; var_dump( $owt ); die;
            if( ! isset($operationsTotalCount[$owt['operationId']] ) ) {
                $operationsTotalCount[$owt['operationId']] = 0;
            }
            
            if( $groupOperations ) {
                $operationsTotalCount[$owt['operationId']] += $owt['sum_count'];
                $grandTotal += $owt['sum_total'];
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
    function getOperationsWorkCount( $modelId, $minDate, $maxDate, $groupOperations = false )
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
            $qb->select( $this->groupOperationsSelect() )
                ->groupBy( 'owt.operationId' )
                //->orderBy( 'CAST(owt.operationNumber AS UNSIGNED)', 'DESC' );
                ->orderBy( 'owt.operationNumber', 'DESC' );
        }
        
        $query                  = $qb->getQuery();
        $listOperations         = [];
        $grandTotal             = 0;
        $operationsTotalCount   = [];
        
        //$this->debugQuery( $query );
        foreach ( $query->getResult( AbstractQuery::HYDRATE_ARRAY ) as $owt ) {
            if( ! isset($operationsTotalCount[$owt['operationId']] ) ) {
                $operationsTotalCount[$owt['operationId']] = 0;
            }
            
            if( $groupOperations ) {
                $operationsTotalCount[$owt['operationId']] += $owt['sum_count'];
                $grandTotal += $owt['sum_total'];
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
    
    private function groupOperationsSelect() : array
    {
        return [
            'owt.modelNumber AS modelNumber',
            'owt.modelName AS modelName',
            'owt.operationId AS operationId',
            'owt.operationName AS operationName',
            'MAX(owt.price) AS max_price',
            'SUM(owt.count) AS sum_count',
            'SUM(owt.total) AS sum_total'
        ];
    }
    
    private function debugQuery( $query )
    {
        echo "<pre>";
        
        var_dump( $query->getSQL() );
        echo "<br><br>";
        var_dump( $query->getParameters() );
        
        die;
    }
}
