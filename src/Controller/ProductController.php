<?php

namespace App\Controller;

use App\Entity\Product\Product;
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
    public function getProducts(Request $request)
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit',6)
        );

        $pagination->setCustomParameters(array(
            'align' => 'center',
        ));

        if ($products === null) {
            return new View("there are no products exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/index.html.twig', array("products" => $pagination));
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
        $productColors = 0;

        for($i=0; $i<count($productSizes); $i++) {
            if ($i === 0) {
                $productColors = $this->getDoctrine()->getRepository(Color::class)->findBy(['Size' => $productSizes[$i]->getId()]);
            }else{
                $productColors[$i] = $this->getDoctrine()->getRepository(Color::class)->findBy(['Size' => $productSizes[$i]->getId()]);
                $productColors = $productColors + $productColors[$i];
            }
        }


        if ($product === null) {
            return new View("Product id: " . $id . " doesn't exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/product.html.twig', array('product'=>$product));
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
     * @Rest\Get("/category/{category}", name="productsCategory")
     */
    public function getProductsByCategory(Request $request, $category)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy(['Category' => $category]);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $product,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit',6)
        );

        $pagination->setCustomParameters(array(
            'align' => 'center',
        ));

        if ($product === null) {
            return new View("Product category: ".$category." doesn't exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/index.html.twig', array('products' => $pagination, 'category'=>$category));
        }
    }

    /**
     * @Rest\Get("products/category/{category}/{brand}", name="productsCategoryBrand")
     */
    public function getProductsByCategoryAndBrand(Request $request, $category, $brand)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy([
            'Category' => $category,
            'Brand' => $brand,
        ]);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $product,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit',5)
        );

        $pagination->setCustomParameters(array(
            'align' => 'center',
        ));

        if ($product === null) {
            return new View("Product category: ".$category." doesn't exist", Response::HTTP_NOT_FOUND);
        }else{
            return $this->render('product/index.html.twig', array('products' => $pagination));
        }
    }

    /**
     * @Rest\Get("products/{id}/reviews", name="productReviews")
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






}
