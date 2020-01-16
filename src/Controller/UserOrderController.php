<?php

namespace App\Controller;

use App\Entity\UserOrder;
use App\Entity\UserOrderDetail;
use App\Form\UserOrderEditType;
use App\Form\UserOrderProductsType;
use App\Form\UserOrderType;
use App\Repository\UserOrderDetailsRepository;
use App\Repository\UserOrderRepository;
use App\Service\MoneroPaymentService;
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
    public function addInformationsOrder(Request $request, $paymentId, UserOrderRepository $orderRepository, EntityManagerInterface $manager)
    {
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
            'orderStep' => 'informations'
        ]);
    }

    /**
     * @Route("/orders/{paymentId}", name="user_order_details")
     */
    public function detailsOrder($paymentId, UserOrderRepository $orderRepository, UserOrderDetailsRepository $orderDetailsRepository)
    {
        $userOrder = $orderRepository->findOneBy(['paiementId' => $paymentId]);

        $productsOrder = $orderDetailsRepository->findBy(['userOrder' => $userOrder->getId()]);


        return $this->render('user_order/details_order.html.twig', [
            'orderStep' => 'details',
            'userOrder' => $userOrder,
            'productsOrder' => $productsOrder
        ]);
    }

    /**
     * @Route("/orders/{paymentId}/pay", name="user_order_pay")
     */
    public function payOrder($paymentId, MoneroPaymentService $moneroPaymentService, UserOrderRepository $userOrderRepository, UserOrderDetailsRepository $orderDetailsRepository)
    {
        $userOrder = $userOrderRepository->findOneBy(['paiementId' => $paymentId]);

        $productsOrder = $orderDetailsRepository->findBy(['userOrder' => $userOrder->getId()]);

        $total = 0;
        foreach ($productsOrder as $product) {
            $totalProductsEUR = $total + $product->getPrice()*$product->getQuantityOrder();
        }

        $totalProductsXMR = $totalProductsEUR/$moneroPaymentService->getMoneroPriceEUR();

        $totalProductsXMR = round($totalProductsXMR,4);

        $moneroPrice = $moneroPaymentService->getMoneroPriceEUR();

        return $this->render('user_order/payment_order.html.twig', [
            'orderStep' => 'payment',
            'userOrder' => $userOrder,
            'moneroPrice' => $moneroPrice,
            'totalProductsEUR' => $totalProductsEUR,
            'totalProductsXMR' => $totalProductsXMR
        ]);
    }

    /**
     * @Route("/orders/{paymentId}/confirm", name="user_order_confirm")
     */
    public function confirmOrder($paymentId)
    {
        return $this->render('user_order/confirm_order.html.twig', [
            'orderStep' => 'confirm'
        ]);
    }

    /**
     * @Route("/orders/{paymentId}/status", name="user_order_status")
     */
    public function getStatusOrder($paymentId)
    {
        return $this->render('user_order/track_order.html.twig', [
            'controller_name' => 'UserOrderController',
        ]);
    }

    /**
     * @Route("/orders/{paymentId}/edit", name="user_order_edit")
     */
    public function editOrder($paymentId)
    {
        $form = $this->createForm(UserOrderEditType::class);

        return $this->render('user_order/edit_order.html.twig', [
            'form' => $form->createView(),
            'paiementId' => $paymentId,
            'orderStep' => 'informations',
        ]);
    }

}
