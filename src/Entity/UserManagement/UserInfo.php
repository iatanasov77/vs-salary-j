<?php namespace App\Entity\UserManagement;

use Doctrine\ORM\Mapping as ORM;
use Vankosoft\UsersBundle\Model\UserInfo as BaseUserInfo;

/**
 * @ORM\Entity
 * @ORM\Table(name="VSUM_UsersInfo")
 */
class UserInfo extends BaseUserInfo
{
    const TITLE_MISTER  = 'mister';
    const TITLE_MRS     = 'mrs';
    const TITLE_MISS    = 'miss';
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", columnDefinition="ENUM('mister', 'mrs', 'miss')", nullable=true)
     */
    private $title;
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle( $title ): self
    {
        $this->title    = $title;
        
        return $this;
    }
}
