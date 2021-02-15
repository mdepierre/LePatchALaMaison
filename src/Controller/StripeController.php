<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{orderid}", name="stripe_create_session")
     */
    public function index(EntityManagerInterface $entityManager, $orderid): Response
    {
        
        $product_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        $order = $entityManager->getRepository(Order::class)->findOneBy(['id' => $orderid]);

        if (!$order){
            $response = new JsonResponse(['error' => 'order']);
        }

        foreach ($order->getOrderDetails()->getValues() as $product) {
            $product_object = $entityManager->getRepository(Product::class)->findOneByName($product->getProduct());
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN."/uploads/".$product_object->getIllustration()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        

        \Stripe\Stripe::setApiKey('sk_test_51IJ8VEF5kj9oHbQsXZjAL6mR4fKGH5TSz2e0JmC9HlUX8LZoYuelf3nW1MnNThOZcGbbM3v56tAELhuK6karQkLa00fJPteckr');

            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    $product_for_stripe
                ],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/commande/succes/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $YOUR_DOMAIN . '/commande/echec/{CHECKOUT_SESSION_ID}',
            ]);

            $order->setCheckoutId($checkout_session->id);

            
            $entityManager->flush();
            // dd($order->getCheckoutId());

            $response = new JsonResponse(['id' => $checkout_session->id]);
            return $response;
    }
}
