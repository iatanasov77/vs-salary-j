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
     * @ORM\Column(type="string", columnDefinition="ENUM('mister', 'mrs', 'miss')", nullable=false)
     */
    private $title;
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle( $title ): self
    {
        if ( ! in_array( $title, [self::TITLE_MISTER, self::TITLE_MRS, self::TITLE_MISS] ) ) {
            throw new \InvalidArgumentException( "Invalid title" );
        }
        $this->title    = $title;
        
        return $this;
    }
}
