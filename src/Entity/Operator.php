<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Sylius\Component\Resource\Model\ResourceInterface;

use VS\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface;
use VS\ApplicationBundle\Model\Traits\ApplicationRelationEntity;
use VS\ApplicationBundle\Model\Interfaces\UserAwareInterface;
use VS\ApplicationBundle\Model\Traits\UserAwareEntity;

/**
 * Operators
 *
 * @ORM\Table(name="JUN_Operators", indexes={@ORM\Index(name="groups_id", columns={"groups_id"})})
 * @ORM\Entity
 */
class Operator implements ResourceInterface, ApplicationRelationInterface, UserAwareInterface
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
     * @var int
     *
     * @ORM\Column(name="groups_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="OperatorsGroup")
     *
     * @Assert\NotBlank
     */
    private $groupsId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     * @Assert\NotBlank
     */
    private $name;
    
    public function __construct()
    {
        //$this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupsId(): ?int
    {
        return $this->groupsId;
    }

    public function setGroupsId(int $groupsId): self
    {
        $this->groupsId = $groupsId;

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
}
