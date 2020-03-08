<?php

namespace App\Service;

use App\Entity\Status;
use App\Entity\UserOrder;
use App\Entity\UserOrderDetail;
use App\Entity\UserOrderStatus;
use App\Repository\ProductRepository;
use App\Repository\StatusOrderRepository;
use App\Repository\UserOrderDetailsRepository;
use App\Repository\UserOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService {

    private $userOrder;
    private $manager;
    private $statusOrderRepository;
    private $productRepository;

    public function __construct(EntityManagerInterface $manager,
                                StatusOrderRepository $statusOrderRepository,
                                ProductRepository $productRepository,
                                UserOrderRepository $userOrderRepository, UserOrderDetailsRepository $userOrderDetailsRepository){
        $this->manager = $manager;
        $this->statusOrderRepository = $statusOrderRepository;
        $this->productRepository = $productRepository;
        $this->userOrderRepository = $userOrderRepository;
        $this->userOrderDetailsRepository = $userOrderDetailsRepository;
    }

    public function orderExist($paiementId) :bool {
        $order = $this->userOrderRepository->findOneBy(['paiementId' => $paiementId]);
        return $order ==! null;
    }

    public function getOrder($paiementId) :UserOrder {
        return $this->userOrderRepository->findOneBy(['paiementId' => $paiementId]);
    }

    public function getProductsOrder($order) {
        return $this->userOrderDetailsRepository->findBy(['userOrder' => $order]);
    }

    public function getTotalEur($paiementId) :float {
        $productsOrder = $this->getProductsOrder($this->getOrder($paiementId));
        $total = 0;
        foreach ($productsOrder as $productOrder) {
            $totalRow = $productOrder->getPrice()*$productOrder->getQuantityOrder();
            $total = $total+$totalRow;
        }
        return $total;
    }

    //temp for test
    public function getTotalXMR($paiementId) :float {
        return 1.22;
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

    public function orderIsLocked(String $paiementId) {
        $order = $this->userOrderRepository->findOneBy(['paiementId' => $paiementId]);
        return $order->getIsLock();
    }
}
