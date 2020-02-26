<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CodeRepository")
 */
class Code
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeSecure;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cle", inversedBy="codes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Cle;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCodeSecure(): ?string
    {
        return $this->codeSecure;
    }

    public function setCodeSecure(string $codeSecure): self
    {
        $this->codeSecure = $codeSecure;

        return $this;
    }

    public function getCle(): ?Cle
    {
        return $this->Cle;
    }

    public function setCle(?Cle $Cle): self
    {
        $this->Cle = $Cle;

        return $this;
    }

}
