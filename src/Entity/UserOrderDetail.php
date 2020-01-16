<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserOrderDetailsRepository")
 */
class UserOrderDetail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserOrder", cascade={"persist"})
     */
    private $userOrder;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="userOrderDetails", cascade={"persist"})
     * @Assert\NotNull
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $quantityOrder;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantityOrder(): ?int
    {
        return $this->quantityOrder;
    }

    public function setQuantityOrder(int $quantityOrder): self
    {
        $this->quantityOrder = $quantityOrder;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
