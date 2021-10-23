<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

use VS\ApplicationBundle\Model\Interfaces\TaxonInterface;
use VS\ApplicationBundle\Model\Taxon;
use VS\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface;
use VS\ApplicationBundle\Model\Traits\ApplicationRelationEntity;

/**
 * OperatorsGroups
 *
 * @ORM\Table(name="JUN_OperatorsGroups")
 * @ORM\Entity
 */
class OperatorsGroup implements ResourceInterface, ApplicationRelationInterface
{
    use ApplicationRelationEntity;
    
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
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;
    
    /**
     * @var Collection|Operator[]
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Operator", mappedBy="groupsId")
     */
    protected $operators;
    
    /**
     * @var TaxonInterface
     * 
     * @ORM\ManyToOne(targetEntity="VS\ApplicationBundle\Model\Interfaces\TaxonInterface", inversedBy="children", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="id", nullable=false)
     */
    protected $taxon;
    
    /**
     * @var OperatorsGroup
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\OperatorsGroup", inversedBy="children", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="id", nullable=true)
     */
    protected $parent;
    
    /**
     * @var Collection|OperatorsGroup[]
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\OperatorsGroup", mappedBy="parent")
     */
    protected $children;
    
    public function __construct()
    {
        $this->operators    = new ArrayCollection();
        $this->children     = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        if ( ! $this->operators->contains( $operator ) ) {
            $this->operators->removeElement( $operator );
            $operator->removeGroup( $this );
        }
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTaxon(): ?TaxonInterface
    {
        return $this->taxon;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setTaxon(?TaxonInterface $taxon): void
    {
        $this->taxon = $taxon;
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
