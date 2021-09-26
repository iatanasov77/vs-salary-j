<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperatorsWork
 *
 * @ORM\Table(name="operators_work")
 * @ORM\Entity
 */
class OperatorsWork
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="operators_id", type="integer", nullable=false)
     */
    private $operatorsId;

    /**
     * @var int
     *
     * @ORM\Column(name="operations_id", type="integer", nullable=false)
     */
    private $operationsId;

    /**
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

    /**
     * @var int
     *
     * @ORM\Column(name="added_by", type="integer", nullable=false)
     */
    private $addedBy = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="updated_by", type="integer", nullable=false)
     */
    private $updatedBy = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added_at", type="datetime", nullable=false)
     */
    private $addedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperatorsId(): ?int
    {
        return $this->operatorsId;
    }

    public function getOperationsId(): ?int
    {
        return $this->operationsId;
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

    public function getAddedBy(): ?int
    {
        return $this->addedBy;
    }

    public function setAddedBy(int $addedBy): self
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(int $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeInterface $addedAt): self
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setOperation(?Operations $operation): self
    {
        $this->operation = $operation;

        return $this;
    }
    
    public function setOperationsId(  $operationsId ): self
    {
        $this->operationsId = $operationsId;
        
        return $this;
    }
    
    public function setOperatorsId( $operatorsId ): self
    {
        $this->operatorsId = $operatorsId;
        
        return $this;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        
        return $this;
    }

}
