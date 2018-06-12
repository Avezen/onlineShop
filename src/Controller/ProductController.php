<?php

namespace App\Controller;

use App\Entity\Product\Product;
use App\Entity\Product\Characteristic;
use App\Entity\Product\Color;
use App\Entity\Product\Review;
use App\Entity\Product\Size;

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
     * @Rest\Get("product/{id}", name="product")
     */
    public function getProduct($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $productReviews = $this->getDoctrine()->getRepository(Review::class)->findBy(['Product' => $id]);
        $productSizes = $this->getDoctrine()->getRepository(Size::class)->findBy(['Product' => $product->getId()]);
        $productColors = $this->getDoctrine()->getRepository(Color::class)->findBy(['Size' => $productSizes[1]->getId()]);



        if ($product === null) {
            return new View("Product id: " . $id . " doesn't exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/product.html.twig', array(
                'product' => $product,
                'productReviews' => $productReviews,
                'productSizes' => $productSizes,
                'productColors' => $productColors,
                ));
        }
    }

    /**
     * @Rest\Get("products/brand/{brand}", name="productsBrand")
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
     * @Rest\Get("products/category/{category}", name="productsCategory")
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
     * @Rest\Get("products/category/{category}/{brand}", name="productsCategoryBrand")
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
     * @Rest\Get("products/{id}/reviews/", name="productReviews")
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


}
