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
     * @Rest\Get("/addproduct/{name}/{description}/{category}/{price}/{photo}/{brand}/{sex}/{origin}/{materials}", name="addproduct")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     */
    public function addProduct($name, $description, $category, $price, $photo, $brand, $sex, $origin, $materials)
    {
        $data = new Product();

        $session = new Session();

        $date = \DateTime::createFromFormat('y-m-d', date("y-m-d"));

        if(empty($name) ||  empty($description)|| empty($brand)|| empty($price) || empty($date))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setName($name);
        $data->setDescription($description);
        $data->setCategory($category);
        $data->setPrice($price);
        $data->setPhoto($photo);
        $data->setBrand($brand);
        $data->setSex($sex);
        $data->setOrigin($origin);
        $data->setMaterials($materials);
        $data->setDate($date);

        $session->set("product", $data);

        return $this->render('Admin/setProductSizes.html.twig', array("product"=>$session));
    }

    /**
     * @Rest\Get("/addProductForm", name="addProductForm")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addProductForm(){

        return $this->render('Admin/addProduct.html.twig');
    }

    /**
     * @Rest\Get("/adminpanel", name="adminpanel")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function admin(){
        $orders = $this->getDoctrine()->getRepository(Orders::class)->findAll();

        return $this->render('Admin/orderList.html.twig', array("orders"=>$orders));
    }
}
