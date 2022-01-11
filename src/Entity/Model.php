<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Sylius\Component\Resource\Model\ResourceInterface;

use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface;
use Vankosoft\ApplicationBundle\Model\Traits\ApplicationRelationEntity;
use Vankosoft\ApplicationBundle\Model\Interfaces\UserAwareInterface;
use Vankosoft\ApplicationBundle\Model\Traits\UserAwareEntity;

/**
 * Models
 *
 * @ORM\Table(name="JUN_Models")
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Model implements ResourceInterface, ApplicationRelationInterface, UserAwareInterface
{
    use ApplicationRelationEntity;
    use UserAwareEntity;
    use TimestampableEntity;
    use SoftDeleteableEntity;
    
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
     * @ORM\OneToMany(targetEntity="App\Entity\Operation", mappedBy="model")
     */
    private $operations;
    
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
    
    /**
     * @return Collection|Operations[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }
}
