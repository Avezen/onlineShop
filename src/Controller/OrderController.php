<?php

namespace App\Controller;

use App\Entity\Order\Address;
use App\Entity\Order\DeliveryMethod;
use App\Entity\Order\Orders;
use App\Entity\Order\OrderDetails;
use App\Entity\Order\PackageMethod;
use App\Entity\Product\Color;
use App\Entity\Product\Product;
use App\Entity\Product\Size;
use Doctrine\Common\Util\ClassUtils;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class OrderController extends FOSRestController
{
    /**
     * @Rest\Get("/makingOrder", name="makingOrder")
     */
    public function makeOrder(Request $request){
        $session = new Session();

        $cart = $session->get('shoppingCart');
        $products = array($this->getDoctrine()->getRepository(Product::class)->findOneBy(["id"=>$cart[0]["id"]]));

        $sizes = array($this->getDoctrine()->getRepository(Size::class)->findOneBy(
                [
                    "Name" => $cart[0]["size"],
                    "Product" => $cart[0]["id"],
                ]
        ));

        $colors = array($this->getDoctrine()->getRepository(Color::class)->findOneBy(
            [
                "Color" => $cart[0]["color"],
                "Size" => $sizes[0],
            ]
        ));
        for($i = 1; $i< count($cart); $i++) {

            array_push($products, $this->getDoctrine()->getRepository(Product::class)->findOneBy(["id" => $cart[$i]["id"]]) );
            array_push($sizes, $this->getDoctrine()->getRepository(Size::class)->findOneBy(
                [
                    "Name" => $cart[$i]["size"],
                    "Product" => $cart[$i]["id"],
                ]
            ));
            array_push($colors, $this->getDoctrine()->getRepository(Color::class)->findOneBy(
                [
                    "Color" => $cart[$i]["color"],
                    "Size" => $sizes[$i],
                ]
            ));
        }
        return $this->render('order/index.html.twig', ["products" => $products, "sizes" => $sizes, "colors" => $colors]);
        //return ["products" => $products, "sizes" => $sizes, "products" => $colors];
    }

    /**
     * @Rest\Get("/testMethod", name="testMethod")
     */
    public function testMethod(Request $request){
        $packageMethods = $this->getDoctrine()->getRepository(PackageMethod::class)->findAll();
        $deliveryMethods = $this->getDoctrine()->getRepository(DeliveryMethod::class)->findAll();




        return array("deliveryMethods"=>$this->container->get('request_stack')->getMasterRequest()->getClientIp());
    }

    /**
     * @Rest\Post("/setAddress", name="setAddress")
     */
    public function setAddress(ValidatorInterface $validator, Request $request){
        $session = new Session();
        $deliveryMethods = new DeliveryMethod();

        $deliveryMethods = $this->getDoctrine()->getRepository(DeliveryMethod::class)->findAll();


        $data = new Address();


        $country = $request->get('_country');
        $postalCode = $request->get('_postalcode');
        $city = $request->get('_city');
        $streetNr = $request->get('_streetnr');


        if(empty($country) ||  empty($postalCode)|| empty($city)|| empty($streetNr) )
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setCountry($country);
        $data->setPostalCode($postalCode);
        $data->setCity($city);
        $data->setStreetNr($streetNr);

        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }


        $session->set('address', $data);

        return $this->render('order/deliveryMethod.html.twig', array('deliveryMethods' => $deliveryMethods));

    }


    /**
     * @Rest\Get("/setDeliveryMethod/{packageMethod}", name="setDeliveryMethod")
     */
    public function setDeliveryMethod($packageMethod){
        $session = new Session();


        $session->set('deliveryMethod', $packageMethod);

        return $this->render('order/setPaymentMethod.html.twig');

    }

    /**
     * @Rest\Get("/setPaymentMethod/{paymentMethod}", name="setPaymentMethod")
     */
    public function setPaymentMethod($paymentMethod){
        $session = new Session();

        $session->set('paymentMethod', $paymentMethod);

        return $this->render('order/finishOrder.html.twig');

    }

    /**
    * @Rest\Post("/finalizeOrder", name="finalizeOrder")
    */
    public function finalizeOrder(){
        $session = new Session();

        $order = new Orders();

        $address = $session->get('address');
        $paymentMethod = $session->get('paymentMethod');
        $cart = $session->get('shoppingCart');

        $packageMethod = $this->getDoctrine()->getRepository(PackageMethod::class)->findOneBy(["id"=>$session->get('deliveryMethod')]);



        $em = $this->getDoctrine()->getManager();
        $em->persist($address);
        $order->setPackageMethod($packageMethod);
        $order->setPaymentMethod($paymentMethod);
        $order->setStatus("Zapłacone");
        $order->setAddress($address);


        $em->persist($order);
        $em->flush();


        for($i=0; $i<count($cart); $i++) {
            $orderDetails = new OrderDetails();

            $orderDetails->setColor($cart[$i]["color"]);
            $orderDetails->setSize($cart[$i]["size"]);
            $orderDetails->setQuantity($cart[$i]["quantity"]);
            $orderDetails->setProductId($cart[$i]["id"]);
            $orderDetails->setOrder($order);
            $em->persist($orderDetails);
            $em->flush();


        }
        return $this->render('order/finishOrder.html.twig');
    }


}
