<?php

namespace App\Controller;

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

class CartController extends FOSRestController
{
    /**
     * @Rest\Get("/addtocart/{id}/{product}/{quantity}/{size}/{color}/{price}", name="addToCart")
     */
    public function addToCart($id, $product, $quantity, $size, $color, $price){
        $session = new Session();


        if($session->get('shoppingCart') === null ){
            $cart = array("0" =>array("id"=>$id, "item"=>$product, "quantity"=> $quantity, "size"=>$size, "color"=>$color, "price"=>$price));
            $session->set('shoppingCart', $cart);

            $session->set('cartPrice', $price * $quantity);
        }else{
            $cart = $session->get('shoppingCart');
            $cartPrice = $session->get('cartPrice');

            array_push($cart,  array("id"=>$id, "item"=>$product, "quantity"=>$quantity, "size"=>$size, "color"=>$color, "price"=>$price));

            $session->set('shoppingCart', $cart);

            $session->set('cartPrice', $cartPrice + $price*$quantity);

        }
        return $this->redirectToRoute('main');
    }

    /**
     * @Rest\Get("/shoppingCart", name="shoppingCart", options={"expose"=true})
     */
    public function readCart(Request $request){
        $session = new Session();
        $shoppingCart = $session->get('shoppingCart');
        //$session->remove('shoppingCart');
        return $this->render('cart/shoppingCart.html.twig', array('shoppingCart' => $shoppingCart));

    }

    /**
     * @Rest\Get("/shoppingCart/clear", name="clearCart")
     */
    public function clearCart(){
        $session = new Session();

        $session->remove('shoppingCart');
        $shoppingCart = $session->get('shoppingCart');


        return $this->render('cart/shoppingCart.html.twig', array('shoppingCart' => $shoppingCart));

    }

    /**
     * @Rest\Get("/shoppingCart/delete/{id}", name="deleteItemFromCart")
     */
    public function deleteFromCart($id){
        $session = new Session();

        $cart = $session->get('shoppingCart');
        $cartPrice = $session->get('cartPrice');

        $quantity = $cart[$id]["quantity"];
        $price = $cart[$id]["price"];
        $session->set('cartPrice', $cartPrice - $quantity*$price);

        array_splice($cart,$id,1);
        $session->set('shoppingCart',$cart);

        return $this->render('cart/shoppingCart.html.twig', array('shoppingCart' => $cart));

    }
}
