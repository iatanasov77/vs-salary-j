<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "JUN_OperatorsWorkTotals")]
class OperatorsWorkTotals
{    
    /** @var int */
    #[ORM\Id, ORM\Column(type: "integer"), ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;
    
    /** @var int */
    #[ORM\Column(name: "operators_id", type: "integer")]
    private $operatorId;
    
    /** @var int */
    #[ORM\Column(name: "operations_id", type: "integer")]
    private $operationId;
    
    /** @var \DateTime */
    #[ORM\Column(type: "date")]
    private $date;

    /** @var float */
    #[ORM\Column(type: "float", precision: 10, scale: 0)]
    private $price;
    
    /** @var int */
    #[ORM\Column(type: "integer")]
    private $count;
    
    /** @var float */
    #[ORM\Column(type: "float", precision: 10, scale: 0)]
    private $total;
    
    /** @var int */
    #[ORM\Column(name: "group_id", type: "integer")]
    private $groupId;
    
    /** @var string */
    #[ORM\Column(name: "operator_name", type: "string")]
    private $operatorName;
    
    /** @var int */
    #[ORM\Column(name: "operation_id", type: "integer")]
    private $operationNumber;
    
    /** @var string */
    #[ORM\Column(name: "operation_name", type: "string")]
    private $operationName;
    
    /** @var int */
    #[ORM\Column(name: "models_id", type: "integer")]
    private $modelId;
    
    /** @var int */
    #[ORM\Column(name: "model_number", type: "integer")]
    private $modelNumber;
    
    /** @var string */
    #[ORM\Column(name: "model_name", type: "string")]
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
