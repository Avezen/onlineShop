<?php

namespace App\Controller;

use App\Entity\Order\Orders;
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

class AdminController extends FOSRestController
{
    /**
     * @Rest\Post("/addproduct", name="addproduct")
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
     * @Rest\Get("/adminpanel", name="adminpanel")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function admin(){
        $orders = $this->getDoctrine()->getRepository(Orders::class)->findAll();

        return $this->render('Admin/addProduct.html.twig', array("orders"=>$orders));
    }
}
