<?php namespace App\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

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
}
