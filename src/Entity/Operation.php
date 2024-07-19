<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Sylius\Component\Resource\Model\ResourceInterface;

use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface;
use Vankosoft\ApplicationBundle\Model\Traits\ApplicationRelationEntity;
use Vankosoft\ApplicationBundle\Model\Interfaces\UserAwareInterface;
use Vankosoft\ApplicationBundle\Model\Traits\UserAwareEntity;

#[ORM\Entity]
#[ORM\Table(name: "JUN_Operations")]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
class Operation implements ResourceInterface, ApplicationRelationInterface, UserAwareInterface
{
    use ApplicationRelationEntity;
    use UserAwareEntity;
    use TimestampableEntity;
    use SoftDeleteableEntity;
    
    /** @var int */
    #[ORM\Id, ORM\Column(type: "integer"), ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;
    
    /** @var Model */
    #[ORM\ManyToOne(targetEntity: "Model", inversedBy: "operations", cascade: ["persist"], fetch: "EAGER")]
    #[ORM\JoinColumn(name: "model_id", referencedColumnName: "id", nullable: false)]
    #[Gedmo\SortableGroup]
    private $model;

    /** @var int */
    #[ORM\Column(name: "operation_id", type: "integer", options: ["default" => 0])]
    #[Gedmo\SortablePosition]
    private $operationId;

    /** @var string */
    #[ORM\Column(name: "operation_name", type: "string", length: 255, nullable: false)]
    private $operationName;

    /** @var float */
    #[ORM\Column(type: "float", precision: 10, scale: 0, nullable: false)]
    private $minutes;
    
    /** @var float */
    #[ORM\Column(type: "float", precision: 10, scale: 0, nullable: false)]
    private $price;
    
    /** @var Collection|OperatorsWork[] */
    #[ORM\OneToMany(targetEntity: "OperatorsWork", mappedBy: "operation", cascade: ["persist", "remove"], orphanRemoval: true)]
    private $work;
    
    public function __construct()
    {
        $this->work = new ArrayCollection();
    }
    
    public function getModel()
    {
        return $this->model;
    }
    
    public function setModel( Model $model )
    {
        $this->model    = $model;
        
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelId(): ?int
    {
        return $this->modelId;
    }

    public function setModelId(int $modelId): self
    {
        $this->modelId = $modelId;

        return $this;
    }

    public function getOperationId(): ?int
    {
        return $this->operationId;
    }

    public function setOperationId(int $operationId): self
    {
        $this->operationId = $operationId;

        return $this;
    }

    public function getOperationName(): ?string
    {
        return $this->operationName;
    }

    public function setOperationName(string $operationName): self
    {
        $this->operationName = $operationName;

        return $this;
    }

    public function getMinutes(): ?float
    {
        return $this->minutes;
    }

    public function setMinutes(float $minutes): self
    {
        $this->minutes = $minutes;

        return $this;
    }
    
    public function getPrice(): ?float
    {
        return $this->price;
    }
    
    public function setPrice(float $price): self
    {
        $this->price = $price;
        
        return $this;
    }
    
    /**
     * @return Collection|OperatorsWork[]
     */
    public function getWork(): Collection
    {
        return $this->work;
    }
    
    public function addWork( OperatorsWork $work ) : self
    {
        if ( ! $this->work->contains( $work ) ) {
            $this->work[] = $work;
            $work->setOperation( $this );
        }
        
        return $this;
    }
    
    public function removeWork( OperatorsWork $work ) : self
    {
        if ( $this->work->contains( $work ) ) {
            $this->work->removeElement( $work );
        }
        
        return $this;
    }
}
