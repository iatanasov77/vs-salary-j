<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperatorsWork
 *
 * @ORM\Table(name="JUN_OperatorsWorkTotals")
 * @ORM\Entity
 */
class OperatorsWorkTotals
{    
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="operators_id", type="integer")
     */
    private $operatorId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="operations_id", type="integer")
     */
    private $operationId;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0)
     */
    private $price;
    
    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;
    
    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0)
     */
    private $total;
    
    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer")
     */
    private $groupId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="operator_name", type="string", length=255)
     */
    private $operatorName;
    
    /**
     * @var int
     *
     * @ORM\Column(name="operation_id", type="integer")
     */
    private $operationNumber;
    
    /**
     * @var string
     *
     * @ORM\Column(name="operation_name", type="string", length=255)
     */
    private $operationName;
    
    /**
     * @var int
     *
     * @ORM\Column(name="models_id", type="integer")
     */
    private $modelId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="model_number", type="integer")
     */
    private $modelNumber;
    
    /**
     * @var string
     *
     * @ORM\Column(name="model_name", type="string", length=255)
     */
    private $modelName;
    
    public function getOperatorId() {
        return $this->operatorId;
    }
    
    public function getOperationId() {
        return $this->operationId;
    }
    
    public function getDate() {
        return $this->date;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function getCount() {
        return $this->count;
    }
    
}
