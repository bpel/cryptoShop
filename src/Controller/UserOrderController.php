<?php

namespace App\Controller;

use App\Entity\UserOrder;
use App\Entity\UserOrderDetail;
use App\Entity\UserOrderStatus;
use App\Form\UserOrderEditType;
use App\Form\UserOrderProductsType;
use App\Form\UserOrderType;
use App\Repository\StatusOrderRepository;
use App\Repository\UserOrderDetailsRepository;
use App\Repository\UserOrderRepository;
use App\Service\MoneroPaymentService;
use App\Service\OrderService;
use App\Service\OrderStatusService2;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserOrderController extends AbstractController
{
    /**
     * @Route("/orders/new", name="user_order_create")
     */
    public function createOrder(Request $request, MoneroPaymentService $moneroPaymentService, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserOrderProductsType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $userOrder = new UserOrder();
            $userOrder->setPaiementId($moneroPaymentService->generatePaymentId());
            $userOrder->setIsLock(false);
            $manager->persist($userOrder);

            foreach($form->get('products')->getData() as $productOrder) {
                $userOrderDetail = new userOrderDetail();
                $userOrderDetail->setUserOrder($userOrder);
                $userOrderDetail->setProduct($productOrder['product']);
                $userOrderDetail->setPrice($productOrder['product']->getPrice());
                $userOrderDetail->setQuantityOrder($productOrder['quantity']);
                $manager->persist($userOrderDetail);
            }

            $manager->flush();

            return $this->redirectToRoute('user_order_complete', [
                'paymentId' => $userOrder->getPaiementId()
            ]);
        }

        return $this->render('user_order/add_products_order.html.twig', [
            'form' => $form->createView(),
            'orderStep' => 'products'
        ]);
    }

    /**
     * @Route("/orders/{paymentId}/complete", name="user_order_complete")
     */
    public function addInformationsOrder(Request $request, $paymentId, OrderService $orderService, UserOrderRepository $orderRepository, EntityManagerInterface $manager)
    {
        if (!$orderService->orderExist($paymentId)) {
            $this->addFlash('error', "cette commande n'existe pas.");
            return $this->redirectToRoute('user_order_create');
        }

        if ($orderService->orderIsLocked($paymentId)) {
            $this->addFlash('info', "Cette commande n'est plus modifiable");
            return $this->redirectToRoute('user_order_details', [
                'paymentId' => $paymentId
            ]);
        }

        $userOrder = $orderRepository->findOneBy(['paiementId' => $paymentId]);

        $form = $this->createForm(UserOrderType::class, $userOrder);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($userOrder);
            $manager->flush();

            return $this->redirectToRoute('user_order_details', [
                'paymentId' => $userOrder->getPaiementId()
            ]);
        }

        return $this->render('user_order/add_informations_order.html.twig', [
            'form' => $form->createView(),
            'orderStep' => 'informations',
            'paymentId' => $paymentId
        ]);
    }

    /**
     * @Route("/orders/{paymentId}", name="user_order_details")
     */
    public function detailsOrder($paymentId, OrderService $orderService)
    {
        if (!$orderService->orderExist($paymentId)) {
            $this->addFlash('error', "cette commande n'existe pas.");
            return $this->redirectToRoute('user_order_create');
        }

        $userOrder = $orderService->getOrder($paymentId);

        return $this->render('user_order/details_order.html.twig', [
            'orderStep' => 'details',
            'userOrder' => $userOrder,
            'productsOrder' => $orderService->getProductsOrder($userOrder),
            'paymentId' => $paymentId
        ]);
    }

    /**
     * @Route("/orders/{paymentId}/pay", name="user_order_pay")
     */
    public function payOrder($paymentId, OrderService $orderService, MoneroPaymentService $moneroPaymentService)
    {
        if (!$orderService->orderExist($paymentId)) {
            $this->addFlash('error', "cette commande n'existe pas.");
            return $this->redirectToRoute('user_order_create');
        }

        $xmrAdress = "XMR Adress is not defined";
        if(!empty($_ENV['XMR_ADRESS'])) {
            $xmrAdress = $_ENV['XMR_ADRESS'];
        }

        return $this->render('user_order/payment_order.html.twig', [
            'orderStep' => 'payment',
            'userOrder' => $orderService->getOrder($paymentId),
            'totalProductsEUR' => $orderService->getTotalEur($paymentId),
            'moneroPrice' => $moneroPaymentService->getMoneroPriceEUR(),
            'xmrAdress' => $xmrAdress,
            'paymentId' => $paymentId
        ]);
    }

    /**
     * @Route("/orders/{paymentId}/confirm", name="user_order_confirm")
     */
    public function confirmOrder($paymentId, OrderService $orderService, EntityManagerInterface $manager)
    {
        if (!$orderService->orderExist($paymentId)) {
            $this->addFlash('error', "cette commande n'existe pas.");
            return $this->redirectToRoute('user_order_create');
        }

        $order = $orderService->getOrder($paymentId);
        $order->setIsLock(true);
        $manager->persist($order);
        $manager->flush();

        return $this->render('user_order/confirm_order.html.twig', [
            'orderStep' => 'confirm',
            'paymentId' => $paymentId
        ]);
    }

    /**
     * @Route("/orders/{paymentId}/track", name="user_order_tracking")
     */
    public function trackOrder($paymentId, OrderService $orderService)
    {
        if (!$orderService->orderExist($paymentId)) {
            $this->addFlash('error', "cette commande n'existe pas.");
            return $this->render('user_order/track_order.html.twig');
        }

        $order = $orderService->getOrder($paymentId);

        return $this->render('user_order/track_order.html.twig', [
            'order' => $order
        ]);
    }
}
