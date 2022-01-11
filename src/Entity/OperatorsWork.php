<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Sylius\Component\Resource\Model\ResourceInterface;

use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface;
use Vankosoft\ApplicationBundle\Model\Traits\ApplicationRelationEntity;
use Vankosoft\ApplicationBundle\Model\Interfaces\UserAwareInterface;
use Vankosoft\ApplicationBundle\Model\Traits\UserAwareEntity;

/**
 * OperatorsWork
 *
 * @ORM\Table(name="JUN_OperatorsWork", 
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="opertors_work_unique", 
 *            columns={"operator_id", "operation_id", "date"})
 *    }
 * )
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class OperatorsWork implements ResourceInterface, ApplicationRelationInterface, UserAwareInterface
{
    use ApplicationRelationEntity;
    use UserAwareEntity;
    use TimestampableEntity;
    use SoftDeleteableEntity;
    
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @var Operator
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Operator", inversedBy="work")
     * @ORM\JoinColumn(name="operator_id", referencedColumnName="id", nullable=false)
     */
    private $operator;

    /**
     * @var Operation
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Operation", inversedBy="work")
     * @ORM\JoinColumn(name="operation_id", referencedColumnName="id", nullable=false)
     */
    private $operation;

    /**
     * The Date when Work is Worked ( ! not the date when is created or updated :) )
     * 
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $unitPrice;

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->date;
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
    
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        
        return $this;
    }
}
