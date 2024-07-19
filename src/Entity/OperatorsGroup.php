<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\TaxonDescendentInterface;
use Vankosoft\ApplicationBundle\Model\Traits\TaxonDescendentEntity;
use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface;
use Vankosoft\ApplicationBundle\Model\Traits\ApplicationRelationEntity;
use Vankosoft\ApplicationBundle\Model\Interfaces\UserAwareInterface;
use Vankosoft\ApplicationBundle\Model\Traits\UserAwareEntity;

#[ORM\Entity]
#[ORM\Table(name: "JUN_OperatorsGroups")]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
class OperatorsGroup implements ResourceInterface, TaxonDescendentInterface, ApplicationRelationInterface, UserAwareInterface
{
    use TaxonDescendentEntity;
    use ApplicationRelationEntity;
    use UserAwareEntity;
    use TimestampableEntity;
    use SoftDeleteableEntity;
    
    /** @var int */
    #[ORM\Id, ORM\Column(type: "integer"), ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;
    
    /** @var Collection|Operator[] */
    #[ORM\OneToMany(targetEntity: "Operator", mappedBy: "group", cascade: ["persist", "remove"], orphanRemoval: true)]
    private $operators;
    
    /** @var OperatorsGroup */
    #[ORM\ManyToOne(targetEntity: "OperatorsGroup", inversedBy: "children", cascade: ["all"], fetch: "EAGER")]
    #[ORM\JoinColumn(name: "parent_id", referencedColumnName: "id", onDelete: "CASCADE", nullable: true)]
    private $parent;
    
    /** @var Collection|OperatorsGroup[] */
    #[ORM\OneToMany(targetEntity: "OperatorsGroup", mappedBy: "parent")]
    private $children;
    
    public function __construct()
    {
        $this->operators    = new ArrayCollection();
        $this->children     = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Operators[]
     */
    public function getOparators(): Collection
    {
        return $this->operators;
    }
    
    public function addOperator( Operator $operator ) : OperatorsGroup
    {
        if ( ! $this->operators->contains( $operator ) ) {
            $this->operators[] = $operator;
            $operator->setGroup( $this );
        }
        
        return $this;
    }
    
    public function removeOperator( Operator $operator ) : OperatorsGroup
    {
        if ( $this->operators->contains( $operator ) ) {
            $this->operators->removeElement( $operator );
            $operator->removeGroup( $this );
        }
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent(): ?OperatorsGroup
    {
        return $this->parent;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setParent(?OperatorsGroup $parent) : OperatorsGroup
    {
        $this->parent = $parent;
        
        return $this;
    }
    
    public function getChildren() : Collection
    {
        return $this->children;
    }
    
    public function __toString()
    {
        return $this->taxon ? $this->taxon->getName() : '';
    }
}
