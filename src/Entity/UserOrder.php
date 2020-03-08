<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserOrderRepository")
 */
class UserOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $paiementId;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotNull()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="userOrders")
     * @Assert\NotBlank()
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity="UserOrderStatus")
     */
    private $orderStatuses;

    /**
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="userOrders")
     */
    private $products;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsLock;

    public function __construct()
    {
        $this->orderStatuses = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaiementId(): ?string
    {
        return $this->paiementId;
    }

    public function setPaiementId(?string $paiementId): self
    {
        $this->paiementId = $paiementId;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|UserOrderStatus[]
     */
    public function getOrderStatuses(): Collection
    {
        return $this->orderStatuses;
    }

    public function addOrderStatus(UserOrderStatus $orderStatus): self
    {
        if (!$this->orderStatuses->contains($orderStatus)) {
            $this->orderStatuses[] = $orderStatus;
            $orderStatus->addUserOrder($this);
        }

        return $this;
    }

    public function removeOrderStatus(UserOrderStatus $orderStatus): self
    {
        if ($this->orderStatuses->contains($orderStatus)) {
            $this->orderStatuses->removeElement($orderStatus);
            $orderStatus->removeUserOrder($this);
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addUserOrder($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeUserOrder($this);
        }

        return $this;
    }

    public function getIsLock(): ?bool
    {
        return $this->IsLock;
    }

    public function setIsLock(bool $IsLock): self
    {
        $this->IsLock = $IsLock;

        return $this;
    }
}
