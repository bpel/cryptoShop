<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderStatusRepository")
 */
class UserOrderStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserOrder")
     */
    private $userOrder;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(\DateTimeInterface $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    public function getUserOrder(): ?UserOrder
    {
        return $this->userOrder;
    }

    public function setUserOrder(?UserOrder $userOrder): self
    {
        $this->userOrder = $userOrder;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }
    
}
