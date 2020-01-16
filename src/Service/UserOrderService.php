<?php

namespace App\Service;

use App\Entity\Status;
use App\Entity\UserOrder;
use App\Entity\UserOrderDetail;
use App\Entity\UserOrderStatus;
use App\Repository\ProductRepository;
use App\Repository\StatusOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserOrderService {

    private $userOrder;
    private $manager;
    private $statusOrderRepository;
    private $productRepository;

    public function __construct(EntityManagerInterface $manager, StatusOrderRepository $statusOrderRepository, ProductRepository $productRepository){
        $this->manager = $manager;
        $this->statusOrderRepository = $statusOrderRepository;
        $this->productRepository = $productRepository;
    }

    public function createUserOrder() :void {
        $this->userOrder = new UserOrder();
        $this->manager->persist($this->userOrder);
        $this->manager->flush();
    }

    public function getStatusRecorded() :Status {
        return $this->statusOrderRepository->findOneBy(['name' => 'commande enregistré']);
    }

    public function createUserOrderStatus() :void {
        $orderStatus = new UserOrderStatus();
        $orderStatus->setUserOrder($this->userOrder);
        $orderStatus->setDateUpdate(new \DateTime());
        $orderStatus->setStatus($this->getStatusRecorded());

        $this->manager->persist($orderStatus);
        $this->manager->flush();
    }

    public function checkProductExist($productId) :bool {
        return $this->productRepository->findOneBy(['id' => $productId]) != null;
    }

    public function createOrderDetail($product, $productForm) {
        $orderDetail = new UserOrderDetail();
        $orderDetail->setProduct($product);
        $orderDetail->setPrice($product->getPrice());
        $orderDetail->setQuantityOrder($productForm['quantity']);
        $orderDetail->setUserOrder($this->userOrder);

        $this->manager->persist($orderDetail);
        $this->manager->flush();
    }

    public function getUserOrder() {
        return $this->userOrder;
    }
}
