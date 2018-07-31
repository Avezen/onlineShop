<?php

namespace App\Controller;

use App\Entity\Order\DeliveryMethod;
use App\Entity\Order\Orders;
use App\Entity\Order\PackageMethod;
use App\Entity\Product\Product;
use App\Entity\Product\Color;
use App\Entity\Product\Review;
use App\Entity\Product\Size;

use App\Entity\User;
use Doctrine\DBAL\ConnectionException;
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
use Symfony\Component\Routing\Generator\UrlGenerator;

class AdminController extends FOSRestController
{

    /**
     * @Rest\Get("/getusers/", name="getUsers")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     */
    public function getUsers(){
        $em = $this->getDoctrine()->getManager();

        try{
            $users = $em->getRepository(User::class)->findAll();
        }catch (ConnectionException $connectionException){
            return $connectionException;
        }


        return $this->render('Admin/userList.html.twig', array("users"=>$users));
    }

    /**
     * @Rest\Get("/deleteuser/{id}", name="deleteUser")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     */
    public function deleteUser($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl('getUsers'));
    }

    /**
     * @Rest\Get("/setproductinfo/{name}/{description}/{category}/{price}/{photo}/{brand}/{sex}/{origin}/{materials}", name="setProductInfo")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     */
    public function setProductInfo($name, $description, $category, $price, $photo, $brand, $sex, $origin, $materials)
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

        $session->set("productGeneralInfo", $data);

        return $this->render('Admin/setProductSizes.html.twig', array("productGeneralInfo"=>$session->get("productGeneralInfo")));
    }

    /**
     * @Rest\Get("/setproductsizes/{sizeXS}/{XSvalue1}/{XSvalue2}/{XSvalue3}/{sizeS}/{Svalue1}/{Svalue2}/{Svalue3}/{sizeM}/{Mvalue1}/{Mvalue2}/{Mvalue3}/{sizeL}/{Lvalue1}/{Lvalue2}/{Lvalue3}/{sizeXL}/{XLvalue1}/{XLvalue2}/{XLvalue3}/{sizeXXL}/{XXLvalue1}/{XXLvalue2}/{XXLvalue3}", name="setproductsizes")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     */
    public function setProductSizes($sizeXS, $XSvalue1, $XSvalue2, $XSvalue3,
                                    $sizeS, $Svalue1, $Svalue2, $Svalue3,
                                    $sizeM, $Mvalue1, $Mvalue2, $Mvalue3,
                                    $sizeL, $Lvalue1, $Lvalue2, $Lvalue3,
                                    $sizeXL, $XLvalue1, $XLvalue2, $XLvalue3,
                                    $sizeXXL, $XXLvalue1, $XXLvalue2, $XXLvalue3)
    {

        $initializedflag = false;


        if($sizeXS !== "null")
            $initializedflag = true;
            $sizes = array("XS"=>array("size_one"=>$XSvalue1, "size_two"=>$XSvalue2, "size_three"=>$XSvalue3));

        if($sizeS !== "null" && $initializedflag)
            $sizes += array("S"=> array("size_one"=>$Svalue1, "size_two"=>$Svalue2, "size_three"=>$Svalue3));
        else if($sizeS !== "null" && !$initializedflag) {
            $initializedflag = true;
            $sizes = array("S" => array("size_one" => $Svalue1, "size_two" => $Svalue2, "size_three" => $Svalue3));
        }

        if($sizeM !== "null" && $initializedflag)
            $sizes += array("M"=>array("size_one"=>$Mvalue1, "size_two"=>$Mvalue2, "size_three"=>$Mvalue3));
        else if($sizeM !== "null" && !$initializedflag) {
            $initializedflag = true;
            $sizes = array("M"=>array("size_one"=>$Mvalue1, "size_two"=>$Mvalue2, "size_three"=>$Mvalue3));
        }
        if($sizeL !== "null" && $initializedflag)
            $sizes += array("L"=>array("size_one"=>$Lvalue1, "size_two"=>$Lvalue2, "size_three"=>$Lvalue3));
        else if($sizeL !== "null" && !$initializedflag) {
            $initializedflag = true;
            $sizes = array("L"=>array("size_one"=>$Lvalue1, "size_two"=>$Lvalue2, "size_three"=>$Lvalue3));
        }
        if($sizeXL !== "null" && $initializedflag)
            $sizes += array("XL"=>array("size_one"=>$XLvalue1, "size_two"=>$XLvalue2, "size_three"=>$XLvalue3));
        else if($sizeXL !== "null" && !$initializedflag) {
            $initializedflag = true;
            $sizes = array("XL"=>array("size_one"=>$XLvalue1, "size_two"=>$XLvalue2, "size_three"=>$XLvalue3));
        }
        if($sizeXXL !== "null" && $initializedflag)
            $sizes += array("XXL"=>array("size_one"=>$XXLvalue1, "size_two"=>$XXLvalue2, "size_three"=>$XXLvalue3));
        else if($sizeXXL !== "null" && !$initializedflag) {
            $sizes = array("XXL"=>array("size_one"=>$XXLvalue1, "size_two"=>$XXLvalue2, "size_three"=>$XXLvalue3));
        }
        $session = new Session();
        $session->set("sizes", $sizes);

        return $this->render('admin/setProductColors.html.twig' ,array("sizes"=>$session->get("sizes")));
    }

    /**
     * @Rest\Get("/setproductcolors/{sizeXS}/{sizeS}/{sizeM}/{sizeL}/{sizeXL}/{sizeXXL}", name="setProductColors")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     */
    public function setProductColors($sizeXS, $sizeS, $sizeM, $sizeL, $sizeXL, $sizeXXL)
    {
        $initializedflag = false;

        if($sizeXS !== "null"){
            $initializedflag = true;
            $colorsforsizeXS = explode("&", $sizeXS);
            $colors = array("XS"=>$colorsforsizeXS);
        }

        if($sizeS !== "null" && $initializedflag){
            $colorsforsizeS = explode("&", $sizeS);
            $colors += array("S"=>$colorsforsizeS);
        }else if($sizeS !== "null" && !$initializedflag){
            $initializedflag = true;
            $colorsforsizeS = explode("&", $sizeS);
            $colors = array("S"=>$colorsforsizeS);
        }

        if($sizeM !== "null" && $initializedflag){
            $colorsforsizeM = explode("&", $sizeM);
            $colors += array("M"=>$colorsforsizeM);
        }else if($sizeM !== "null" && !$initializedflag){
            $initializedflag = true;
            $colorsforsizeM = explode("&", $sizeM);
            $colors = array("M"=>$colorsforsizeM);
        }

        if($sizeL !== "null" && $initializedflag){
            $colorsforsizeL = explode("&", $sizeL);
            $colors += array("L"=>$colorsforsizeL);
        }else if($sizeL !== "null" && !$initializedflag){
            $initializedflag = true;
            $colorsforsizeL = explode("&", $sizeL);
            $colors = array("L"=>$colorsforsizeL);
        }

        if($sizeXL !== "null" && $initializedflag){
            $colorsforsizeXL = explode("&", $sizeXL);
            $colors += array("XL"=>$colorsforsizeXL);
        }else if($sizeXL !== "null" && !$initializedflag){
            $initializedflag = true;
            $colorsforsizeXL = explode("&", $sizeXL);
            $colors = array("XL"=>$colorsforsizeXL);
        }

        if($sizeXXL !== "null" && $initializedflag){
            $colorsforsizeXXL = explode("&", $sizeXXL);
            $colors += array("XXL"=>$colorsforsizeXXL);
        }else if($sizeXXL !== "null" && !$initializedflag){
            $colorsforsizeXXL = explode("&", $sizeXXL);
            $colors = array("XXL"=>$colorsforsizeXXL);
        }

        $session = new Session();
        $session->set("colors", $colors);


        return $this->render('admin/addNewProduct.html.twig' ,array("colors" => $session->get("colors")));
    }

    /**
     * @Rest\Get("/addproductform", name="addProductForm")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addProductForm(){

        return $this->render('Admin/setProductInfo.html.twig');
    }

    /**
     * @Rest\Get("/adddelivery", name="addDelivery")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addDelivery(){

        return $this->render('Admin/addDeliveryMethod.html.twig');
    }

    /**
     * @Rest\Post("/addnewproduct", name="addNewProduct")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addNewProduct(){
        $session = new Session();
        $product = new Product();


        $sizes = $session->get("sizes");
        $product = $session->get("productGeneralInfo");
        $colors = $session->get("colors");

        $em = $this->getDoctrine()->getManager();


        $em->persist($product);
        $em->flush();


        foreach($sizes as $key => $value){
            $size = new Size();
            $size->setProduct($product);
            $size->setName($key);

            if($value["size_one"] !== NULL)
                $size->setSizeOne($value["size_one"]);
            if($value["size_two"] !== "null")
                $size->setSizeTwo($value["size_two"]);
            if($value["size_three"] !== "null")
                $size->setSizeThree($value["size_three"]);

            $em->persist($size);
            $em->flush();

            foreach($colors as $s => $c){
                if($s == $key) {
                    for ($i = 0; $i < count($c); $i++) {
                        $color = new Color();
                        $color->setSize($size);
                        $color->setColor($c[$i]);
                        $color->setStock(10);
                        $em->persist($color);
                        $em->flush();
                    }
                }
            }
        }

        return $this->render('admin/index.html.twig');
    }

    /**
     * @Rest\Post("/adddeliverymethod", name="addDeliveryMethod")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addDeliveryMethod(Request $request)
    {
        $deliveryMethods = $request->request->get('deliveryMethod', 0);

        $em = $this->getDoctrine()->getManager();
        $deliveryId = null;

        for($i=0; $i<count($deliveryMethods); $i++) {

            $checkDeliveryExistence = $em->getRepository(DeliveryMethod::class)->findOneBy(array("Name"=>$deliveryMethods[$i]['name']));

            if($checkDeliveryExistence !== null){
                $deliveryId = $checkDeliveryExistence->getId();
                $deliveryMethod = $checkDeliveryExistence;
            }else {
                $deliveryMethod = new DeliveryMethod();
                $deliveryMethod->setName($deliveryMethods[$i]['name']);

                $em->persist($deliveryMethod);
                $em->flush();
            }
            for($j=0; $j<count($deliveryMethods[$i])-1; $j++){

                $checkPackageExistence = $em->getRepository(PackageMethod::class)->findBy(array("DeliveryMethod"=>$deliveryId, "Method"=>$deliveryMethods[$i][$j]['method']));

                if($checkPackageExistence !== []){

                }else{
                    $packageMethod = new PackageMethod();
                    $packageMethod->setDeliveryMethod($deliveryMethod);
                    $packageMethod->setMethod($deliveryMethods[$i][$j]['method']);
                    $packageMethod->setPrice($deliveryMethods[$i][$j]['price']);

                    $em->persist($packageMethod);
                    $em->flush();
                }
            }
        }
        return $this->redirect($this->generateUrl('adminpanel'));
    }

    /**
     * @Rest\Get("/adminpanel", name="adminPanel")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function admin(){
        $orders = $this->getDoctrine()->getRepository(Orders::class)->findAll();

        return $this->render('Admin/orderList.html.twig', array("orders"=>$orders));
    }

    /**
     * @Rest\Get("/orders/{status}", name="orders")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function getOrders($status){
        $orders = $this->getDoctrine()->getRepository(Orders::class)->findBy(array("Status"=>$status));

        return $this->render('Admin/orderList.html.twig', array("orders"=>$orders));
    }

    /**
     * @Rest\Post("deleteproduct/", name="deleteProduct")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteProduct(Request $request)
    {
        $id = $request->request->get('productIdToDelete', 0);
        $sizes = $this->getDoctrine()->getRepository(Size::class)->findBy(array("Product"=> $id));

        $em = $this->getDoctrine()->getManager();

        for($i=0; $i<count($sizes); $i++) {
            $colors = $this->getDoctrine()->getRepository(Color::class)->findBy(array("Size"=> $sizes[$i]->getId()));

            for($j=0; $j<count($colors); $j++){
                $em->remove($colors[$j]);
                $em->flush();
            }

            $em->remove($sizes[$i]);
            $em->flush();
        }

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        if($product !== NULL){
            $em->remove($product);
            $em->flush();
        }



        return $this->redirect($this->generateUrl('main'));

    }

    /**
     * @Rest\Put("/updateprderptatus/{id}", name="updateOrderStatus")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function updateOrderStatus($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Orders::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException(sprintf(
                'No programmer found with nickname "%s"',
                $id
            ));
        }

        $status = $request->request->get('status', 0);

        $order->setStatus($status);

        $em->persist($order);
        $em->flush();

        $orders = $em->getRepository(Orders::class)->findAll();

        return $this->render('Admin/orderList.html.twig', array("orders"=>$orders));
    }

    /**
     * @Rest\Put("/updateproductinfo/{id}", name="updateProductInfo")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function updateProductInfo($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(sprintf(
                'No programmer found with nickname "%s"',
                $id
            ));
        }

        if($request->request->get('Brand', 0) !== 0)
            $product->setBrand($request->request->get('Brand', 0));

        if($request->request->get('Origin', 0) !== 0)
            $product->setOrigin($request->request->get('Origin', 0));

        if($request->request->get('Materials', 0) !== 0)
            $product->setMaterials($request->request->get('Materials', 0));

        if($request->request->get('Description', 0) !== 0)
            $product->setDescription($request->request->get('Description', 0));


        $em->persist($product);
        $em->flush();


        return $this->redirect($this->generateUrl('main'));
    }
}
