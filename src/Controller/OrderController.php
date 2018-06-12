<?php

namespace App\Controller;

use App\Entity\Order\Address;
use App\Entity\Order\DeliveryMethod;
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


class OrderController extends FOSRestController
{
    /**
     * @Rest\Get("/makingOrder/", name="makingOrder")
     */
    public function makeOrder(Request $request){
        // Tutaj ma być pobranie danych z sesji na temat wózka, na podstawie których wyślemy requesty po szczegóły o produktach
        // i przekazemy tablice z tymi danymi do render()

        return $this->render('order/index.html.twig');

    }


    /**
     * @Rest\Post("/setAddress/", name="setAddress")
     */
    public function setAddress(Request $request){
        $session = new Session();

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

        /*
                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();
        */

        $session->set('address', $data);

        return $this->render('order/deliveryMethod.html.twig');

    }


    /**
     * @Rest\Get("/setDeliveryMethod/{name}/{price}/{packageMethod}", name="setDeliveryMethod")
     */
    public function setDeliveryMethod($name, $price, $packageMethod){
        $session = new Session();

        $data = new DeliveryMethod();
        $data ->setName($name);
        $data ->setPrice($price);
        $data ->setPackageMethod($packageMethod);


        $session->set('deliveryMethod', $data);

        return $this->render('order/setPaymentMethod.html.twig');

    }

    /**
     * @Rest\Get("/setPaymentMethod/", name="setPaymentMethod")
     */
    public function setPaymentMethod(Request $request){
        $session = new Session();



        $session->set('paymentMethod');
        return $this->render('order/cartList.html.twig', array('shoppingCart' => $shoppingCart));

    }
}
