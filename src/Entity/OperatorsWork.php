<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Sylius\Component\Resource\Model\ResourceInterface;

use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface;
use Vankosoft\ApplicationBundle\Model\Traits\ApplicationRelationEntity;
use Vankosoft\ApplicationBundle\Model\Interfaces\UserAwareInterface;
use Vankosoft\ApplicationBundle\Model\Traits\UserAwareEntity;

#[ORM\Entity]
#[ORM\Table(name: "JUN_OperatorsWork")]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
class OperatorsWork implements ResourceInterface, ApplicationRelationInterface, UserAwareInterface
{
    use ApplicationRelationEntity;
    use UserAwareEntity;
    use TimestampableEntity;
    use SoftDeleteableEntity;
    
    /** @var int */
    #[ORM\Id]
    #[ORM\Column(type: "integer"), ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;
    
    /** @var Operator */
    #[ORM\ManyToOne(targetEntity: "Operator", inversedBy: "work")]
    #[ORM\JoinColumn(name: "operator_id", referencedColumnName: "id", nullable: false)]
    private $operator;

    /** @var Operation */
    #[ORM\ManyToOne(targetEntity: "Operation", inversedBy: "work")]
    #[ORM\JoinColumn(name: "operation_id", referencedColumnName: "id", nullable: false)]
    private $operation;

    /**
     * The Date when Work is Worked ( ! not the date when is created or updated :) )
     * 
     * \DateTime Cannot be Added as Id - https://stackoverflow.com/questions/17125863/symfony-doctrine-datetime-as-primary-key
     * @var \DateTimeInterface
     */
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private $date;

    /** @var int */
    #[ORM\Column(type: "integer", nullable: false)]
    private $count;

    /** @var float */
    #[ORM\Column(name: "price", type: "decimal", precision: 10, scale: 4, nullable: false)]
    private $unitPrice;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;
        
        return $this;
    }

    public function getOperator(): ?Operator
    {
        return $this->operator;
    }

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return \DateTime::createFromFormat( 'Y-m-d', $this->date );
    }
    
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        
        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function setOperator( $operator ): self
    {
        $this->operator = $operator;
        
        return $this;
    }
    
    public function setOperation(?Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }
}
