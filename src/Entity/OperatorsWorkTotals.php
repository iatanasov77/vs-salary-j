<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="view_operators_work_totals")
 * @ORM\Entity(repositoryClass="App\Repository\OperatorsWorkTotalsRepository")
 */
class OperatorsWorkTotals
{
    private function __construct() {}
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
