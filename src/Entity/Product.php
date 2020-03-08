<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserOrder", mappedBy="products")
     */
    private $userOrders;

    /**
     * @ORM\OneToMany(targetEntity="UserOrderDetail", mappedBy="product")
     */
    private $quantityOrder;

    public function __construct()
    {
        $this->userOrders = new ArrayCollection();
        $this->quantityOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getLabelProductChoice(): ?string {
        return $this->getName() . " " . $this->getPrice() . "€";
    }

    /**
     * @return Collection|UserOrder[]
     */
    public function getUserOrders(): Collection
    {
        return $this->userOrders;
    }

    public function addUserOrder(UserOrder $userOrder): self
    {
        if (!$this->userOrders->contains($userOrder)) {
            $this->userOrders[] = $userOrder;
            $userOrder->addProduct($this);
        }

        return $this;
    }

    public function removeUserOrder(UserOrder $userOrder): self
    {
        if ($this->userOrders->contains($userOrder)) {
            $this->userOrders->removeElement($userOrder);
            $userOrder->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|UserOrderDetail[]
     */
    public function getQuantityOrder(): Collection
    {
        return $this->quantityOrder;
    }

    public function addQuantityOrder(UserOrderDetail $quantityOrder): self
    {
        if (!$this->quantityOrder->contains($quantityOrder)) {
            $this->quantityOrder[] = $quantityOrder;
            $quantityOrder->setProduct($this);
        }

        return $this;
    }

    public function removeQuantityOrder(UserOrderDetail $quantityOrder): self
    {
        if ($this->quantityOrder->contains($quantityOrder)) {
            $this->quantityOrder->removeElement($quantityOrder);
            // set the owning side to null (unless already changed)
            if ($quantityOrder->getProduct() === $this) {
                $quantityOrder->setProduct(null);
            }
        }

        return $this;
    }
}
