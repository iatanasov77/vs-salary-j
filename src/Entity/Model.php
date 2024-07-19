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
#[ORM\Table(name: "JUN_Models")]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
class Model implements ResourceInterface, ApplicationRelationInterface, UserAwareInterface
{
    use ApplicationRelationEntity;
    use UserAwareEntity;
    use TimestampableEntity;
    use SoftDeleteableEntity;
    
    /** @var int */
    #[ORM\Id, ORM\Column(type: "integer"), ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    /** @var string */
    #[ORM\Column(type: "string", length: 8, nullable: false)]
    private $number;

    /** @var string */
    #[ORM\Column(type: "string", length: 64, nullable: false)]
    private $name;
    
    /** @var Collection|Operation[] */
    #[ORM\OneToMany(targetEntity: "Operation", mappedBy: "model", cascade: ["persist", "remove"], orphanRemoval: true)]
    #[ORM\OrderBy(['operationId' => 'ASC'])]
    private $operations;
    
    public function __construct()
    {
        $this->operations   = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }
    
    public function addOperation( Operation $operation ) : self
    {
        if ( ! $this->operations->contains( $operation ) ) {
            $this->operations[] = $operation;
            $operation->setModel( $this );
        }
        
        return $this;
    }
    
    public function removeOperation( Operation $operation ) : self
    {
        if ( $this->operations->contains( $operation ) ) {
            $this->operations->removeElement( $operation );
            //$operation->setModel( null );
        }
        
        return $this;
    }
}
