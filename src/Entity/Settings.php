<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface;
use Vankosoft\ApplicationBundle\Model\Traits\ApplicationRelationEntity;
use Vankosoft\ApplicationBundle\Model\Interfaces\UserAwareInterface;
use Vankosoft\ApplicationBundle\Model\Traits\UserAwareEntity;

#[ORM\Entity]
#[ORM\Table(name: "JUN_Settings")]
class Settings implements ResourceInterface, ApplicationRelationInterface, UserAwareInterface
{
    use ApplicationRelationEntity;
    use UserAwareEntity;
    use TimestampableEntity;
    
    /** @var \Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface */
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: "App\Entity\Application\Application")]
    protected $application;
    
    /** @var string */
    #[ORM\Id]
    #[ORM\Column(name: "var_name", type: "string", length: 64, nullable: false)]
    private $varName;
    
    /** @var string */
    #[ORM\Column(name: "var_value", type: "string", length: 255, nullable: false)]
    private $varValue;
    
    public function getId()
    {
        return $this->application->getId() . '-' . $this->varName;    
    }
    
    public function getVarName() : ?string
    {
        return $this->varName;
    }
    
    public function setVarName( string $varName ) : self
    {
        $this->varName = $varName;
        
        return $this;
    }
    
    public function getVarValue() : ?string
    {
        return $this->varValue;
    }
    
    public function setVarValue( string $varValue ) : self
    {
        $this->varValue = $varValue;
        
        return $this;
    }
}
