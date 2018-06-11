<?php

namespace App\Controller;

use App\Entity\Characteristic;
use App\Entity\Color;
use App\Entity\Review;
use App\Entity\Size;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ProductController extends FOSRestController
{
    /**
     * @Rest\Get("/", name="main")
     */
    public function getProducts()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        if ($products === null) {
            return new View("there are no products exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/index.html.twig', array('products' => $products));
            }
    }

    /**
     * @Rest\Get("product/{id}")
     */
    public function getProduct($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $productDetails = $this->getDoctrine()->getRepository(Characteristic::class)->findOneBy(['Product' => $id]);
        $productReviews = $this->getDoctrine()->getRepository(Review::class)->findBy(['Product' => $id]);
        $productSizes = $this->getDoctrine()->getRepository(Size::class)->findBy(['Characteristic' => $productDetails->getId()]);
        $productColors = $this->getDoctrine()->getRepository(Color::class)->findBy(['Size' => $productSizes[1]->getId()]);



        if ($product === null) {
            return new View("Product id: " . $id . " doesn't exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/product.html.twig', array(
                'product' => $product,
                'productDetails' => $productDetails,
                'productReviews' => $productReviews,
                'productSizes' => $productSizes,
                'productColors' => $productColors,
                ));
        }
    }

    /**
     * @Rest\Get("products/brand/{brand}")
     */
    public function getProductsByBrand($brand)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy(['Brand' => $brand]);

        if ($product === null) {
            return new View("Product brand: ".$brand." doesn't exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/index.html.twig', array('products' => $product));
        }
    }

    /**
     * @Rest\Get("products/category/{category}")
     */
    public function getProductsByCategory($category)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy(['Category' => $category]);

        if ($product === null) {
            return new View("Product category: ".$category." doesn't exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/index.html.twig', array('products' => $product));
        }
    }

    /**
     * @Rest\Get("products/category/{category}/{brand}")
     */
    public function getProductsByCategoryAndBrand($category, $brand)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy([
            'Category' => $category,
            'Brand' => $brand,
        ]);

        if ($product === null) {
            return new View("Product category: ".$category." doesn't exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/index.html.twig', array('products' => $product));
        }
    }

    /**
     * @Rest\Get("products/{id}/reviews/")
     */
    public function getProductReviews()
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy(['Category' => $category]);

        if ($product === null) {
            return new View("Product category: ".$category." doesn't exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/index.html.twig', array('products' => $product));
        }
    }

    /**
     * @Rest\Post("/product/")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     */
    public function addProduct(Request $request)
    {
        $data = new Product();
        $name = $request->get('_name');
        $description = $request->get('_description');
        $brand = $request->get('_brand');
        $price = $request->get('_price');
        $date = \DateTime::createFromFormat('y-m-d', date("y-m-d"));

        if(empty($name) ||  empty($description)|| empty($brand)|| empty($price) || empty($date))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setName($name);
        $data->setDescription($description);
        $data->setBrand($brand);
        $data->setPrice($price);
        $data->setDate($date);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View("Product Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/addToCart/{product}/{quantity}/{size}/{color}/{price}")
     */
    public function addToCart($product, $quantity, $size, $color, $price){
        $session = new Session();


        if($session->get('shoppingCart') === null ){
            $cart = array("0" =>array("item"=>$product, "quantity"=> $quantity, "size"=>$size, "color"=>$color, "price"=>$price));
            $session->set('shoppingCart', $cart);

            $session->set('cartPrice', $price * $quantity);
        }else{
            $cart = $session->get('shoppingCart');
            $cartPrice = $session->get('cartPrice');

            array_push($cart,  array("item"=>$product, "quantity"=>$quantity, "size"=>$size, "color"=>$color, "price"=>$price));

            $session->set('shoppingCart', $cart);

            $session->set('cartPrice', $cartPrice + $price*$quantity);

        }
        return $this->redirectToRoute('main');
    }

    /**
     * @Rest\Get("/shoppingCart/")
     */
    public function readCart(Request $request){
        $session = new Session();
        $shoppingCart = $session->get('shoppingCart');
        //$session->remove('shoppingCart');
        return $this->render('product/shoppingCart.html.twig', array('shoppingCart' => $shoppingCart));

    }

    /**
     * @Rest\Get("/shoppingCart/clear/", name="clearCart")
     */
    public function clearCart(){
        $session = new Session();

        $session->remove('shoppingCart');

        return $this->redirectToRoute('main');

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

        return $this->redirectToRoute('main');

    }
}
