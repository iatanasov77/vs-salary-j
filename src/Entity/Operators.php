<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use VS\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface;
use VS\ApplicationBundle\Model\Traits\ApplicationRelationTrait;

/**
 * Operators
 *
 * @ORM\Table(name="JUN_Operators", indexes={@ORM\Index(name="groups_id", columns={"groups_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\OperatorsRepository")
 */
class Operators implements ApplicationRelationInterface
{
    use ApplicationRelationTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \VS\ApplicationBundle\Model\Interfaces\ApplicationInterface
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Application\Application")
     */
    protected $application;
    
    /**
     * @var int
     *
     * @ORM\Column(name="groups_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="OperatorsGroups")
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

    /**
     * @var int
     *
     * @ORM\Column(name="added_by", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="titles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $addedBy;

    /**
     * @var int
     *
     * @ORM\Column(name="updated_by", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="titles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $updatedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="removed", type="boolean", nullable=false)
     */
    private $removed = '0';
    
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
