<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Vankosoft\ApplicationBundle\Model\Traits\UserAwareEntity;
use Vankosoft\ApplicationBundle\Model\Traits\ApplicationRelationTrait;

use App\Repository\SettingsRepository;

/**
 * Models
 *
 * @ORM\Table(name="JUN_Settings")
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings implements ResourceInterface
{
    use ApplicationRelationTrait;
    use UserAwareEntity;
    use TimestampableEntity;
    
    /**
     * @var \Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Application\Application")
     * @ORM\Id
     */
    protected $application;
    
    /**
     * @var string
     *
     * @ORM\Column(name="var_name", type="string", length=64, nullable=false)
     * @ORM\Id
     */
    private $varName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="var_value", type="string", length=255)
     */
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
