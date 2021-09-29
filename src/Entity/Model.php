<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Models
 *
 * @ORM\Table(name="JUN_Models")
 * @ORM\Entity
 */
class Model
{
    use TimestampableEntity;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=8, nullable=false)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="added_by", type="integer", nullable=false)
     */
    private $addedBy;

    /**
     * @var int
     *
     * @ORM\Column(name="updated_by", type="integer", nullable=false)
     */
    private $updatedBy;

    /**
     * @var bool
     *
     * @ORM\Column(name="removed", type="boolean", nullable=false)
     */
    private $removed = '0';
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operations", mappedBy="model")
     */
    private $operations;
    
    /**
     * @return Collection|Operations[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }
    
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRemoved(): ?bool
    {
        return $this->removed;
    }

    public function setRemoved(bool $removed): self
    {
        $this->removed = $removed;

        return $this;
    }


}
