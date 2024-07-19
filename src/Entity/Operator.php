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
#[ORM\Table(name: "JUN_Operators")]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
class Operator implements ResourceInterface, ApplicationRelationInterface, UserAwareInterface
{
    use ApplicationRelationEntity;
    use UserAwareEntity;
    use TimestampableEntity;
    use SoftDeleteableEntity;
    
    /** @var int */
    #[ORM\Id, ORM\Column(type: "integer"), ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;
    
    /** @var OperatorsGroup */
    #[ORM\ManyToOne(targetEntity: "OperatorsGroup", inversedBy: "operators", cascade: ["persist"], fetch: "EAGER")]
    private $group;

    /** @var string */
    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $name;
    
    /** @var Collection|OperatorsWork[] */
    #[ORM\OneToMany(targetEntity: "OperatorsWork", mappedBy: "operator", cascade: ["persist", "remove"], orphanRemoval: true)]
    private $work;
    
    public function __construct()
    {
        //$this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        
        $this->work = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroup(): ?OperatorsGroup
    {
        return $this->group;
    }

    public function setGroup(?OperatorsGroup $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

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
            $work->setOperator( $this );
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
