<?php namespace App\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Doctrine\ORM\AbstractQuery;
use App\Entity\Operator;
use App\Entity\Operation;

/**
 * MANUALS USING VIEWS:
 * --------------------
 *  https://stackoverflow.com/questions/8377671/how-to-set-up-entity-doctrine-for-database-view-in-symfony-2
 *  https://robbert.rocks/aggregate-your-data-by-using-sql-views-and-doctrine
 */
class OperatorsWorkRepository extends EntityRepository
{
    /**
     * 
     * @param int $operator
     * @param int $operation
     * @param string $date
     * @return int|NULL
     */
    public function getOperatorWorkMaxId( int $operator, int $operation, string $date ): ?int
    {
        $entityManager  = $this->getEntityManager();
        $qb             = $entityManager->createQueryBuilder( 'ow' )
                                        ->select(['MAX(ow.id) AS maxId'])
                                        ->from( 'App\Entity\OperatorsWork', 'ow' )
                                        ->andWhere( 'ow.operator = :operator' )->setParameter( 'operator', $operator )
                                        ->andWhere( 'ow.operation = :operation' )->setParameter( 'operation', $operation )
                                        ->andWhere( 'ow.date = :date' )->setParameter( 'date', $date );
        
        $result         = $qb->getQuery()->getResult();

        return intval ( $result[0]['maxId'] );
    }
    
    /**
     * 
     * @param Operator $operator
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param bool $groupOperations
     * @return array
     */
    public function getWorkForOperator( Operator $operator, \DateTime $startDate, \DateTime $endDate, bool $groupOperations = false ): array
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
     * Got from JunObjectsFactory::operatorsWork
     *
     * @param int $groupId
     * @param \DateTime $minDate
     * @param \DateTime $maxDate
     */
    public function getOperatorsWork( int $groupId, \DateTime $minDate, \DateTime $maxDate )
    {
        // SELECT operators_id, operator_name, SUM(total) AS sub_total FROM JUN_OperatorsWorkTotals WHERE group_id IS NULL AND date = '2021-10-29' GROUP BY operators_id ORDER BY operator_name
        $entityManager  = $this->getEntityManager();
        $qb             = $entityManager->createQueryBuilder( 'owt' )
                                        ->select( 'owt' )
                                        ->select([
                                            'owt.operatorId AS operatorId',
                                            'owt.operatorName AS operatorName',
                                            'SUM(owt.total) AS subTotal',
                                        ])
                                        ->from( 'App\Entity\OperatorsWorkTotals', 'owt' )
                                        ->groupBy( 'owt.operatorId' )
                                        ->orderBy( 'owt.operatorName', 'ASC' );
        
        if ( $groupId ) {
            $qb->andWhere( 'owt.groupId = :groupId' )->setParameter( 'groupId', $groupId );
        } else {
            $qb->andWhere( 'owt.groupId IS NULL' );
        }
        
        //var_dump( $minDate ); die;
        if( $minDate == $maxDate ) {
            $qb->andWhere( 'owt.date = :minDate' )->setParameter( 'minDate', $minDate );
        } else {
            $qb->andWhere( 'owt.date >= :minDate' )->andWhere( 'owt.date <= :maxDate' )
                ->setParameter( 'minDate', $minDate )->setParameter( 'maxDate', $maxDate );
        }

        $work       = [];
        $grandTotal = 0;
        $query      = $qb->getQuery();
        //$this->debugQuery( $query );
        foreach ( $query->getResult( AbstractQuery::HYDRATE_ARRAY ) as $owt ) {
            $work[] = $owt;
            $grandTotal += $owt['subTotal'];
        }
        
        return [
            'work'          => $work,
            'grandTotal'    => $grandTotal,
        ];
    }
    
    /**
     * @NOTE Need Optimization and Refactoring
     * 
     * GOT FROM: JunObjectsFactory::makeOperationsWorkCount
     * ============================================================
     * GroupOperations Query:
     * ------------------------------------------------------
     * SELECT *, SUM(count) AS sum_count, SUM(total) AS sum_total 
     * FROM `operators_work_totals` 
     * WHERE models_id=".$modelId." AND `date`>='".$minDate."' AND `date`<='".$maxDate."'
     * GROUP BY operations_id
     * ORDER BY CAST(operation_id AS UNSIGNED)
     * 
     * 
     * @param int $modelId
     * @param \DateTime | string  $minDate
     * @param \DateTime | string  $maxDate
     * @param boolean $groupOperations
     * 
     * @return unknown[]|number[][]|NULL[][]
     */
    public function getOperationsWorkCount( int $modelId, mixed $minDate, mixed $maxDate, bool $groupOperations = false )
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
    
    public function getOperatorsWorkForFix( \DateTime $startDate, \DateTime $endDate ): array
    {
        $entityManager  = $this->getEntityManager();
        $qb             = $entityManager->createQueryBuilder( 'ow' )
                                        ->select( 'ow' )
                                        ->from( 'App\Entity\OperatorsWork', 'ow' )
                                        ->andWhere( 'ow.unitPrice = 0' )
                                        ->andWhere( 'ow.date >= :minDate' )
                                        ->andWhere( 'ow.date <= :maxDate' )
                                        ->setParameter( 'minDate', $startDate )
                                        ->setParameter( 'maxDate', $endDate );
        
        return $qb->getQuery()->getResult( AbstractQuery::HYDRATE_OBJECT );
    }
    
    /**
     * 
     * @return array
     */
    private function groupOperationsSelect(): array
    {
        return [
            'owt.modelNumber AS modelNumber',
            'owt.modelName AS modelName',
            'owt.operationId AS operationId',
            'owt.operationNumber AS operationNumber',
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
