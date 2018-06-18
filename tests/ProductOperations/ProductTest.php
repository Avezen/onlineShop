<?php
/**
 * Created by PhpStorm.
 * User: maniekcs1995
 * Date: 2018-06-12
 * Time: 23:28
 */

App\Entity\Product\Product::class;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProduct(){
        $product = new \App\Entity\Product\Product();
        $review = new \App\Entity\Product\Review();
        $size = new \App\Entity\Product\Size();
        $color = new \App\Entity\Product\Color();

        $color->setColor("blue");
        $color->setStock(10);

        $size->setName("M");
        $size->setColor($color);
        $size->setSizeOne("15");
        $size->setSizeTwo("17");
        $size->setSizeThree("20");

        $review->setContent("Review content");
        $review->setRating(5);

        $product->setName("product name");
        $product->setDescription("product description");
        $product->setPhoto("http://url.to/photo");
        $product->setPrice(39.99);
        $product->setCategory("T-Shirt");
        $product->setBrand("nike");
        $product->setOrigin("china");
        $product->setMaterials(json_encode(array("wool"=>"90%", "plastic"=>"10%")));
        $product->setDate(\DateTime::createFromFormat('y-m-d', date("y-m-d")));
        $product->setReview($review);
        $product->setSex("male");
        $product->setSize($size);


        $result = $product->getName();
        $this->assertEquals("product name", $result);
        $result = $product->getDescription();
        $this->assertEquals("product description", $result);
        $result = $product->getPhoto();
        $this->assertEquals("http://url.to/photo", $result);
        $result = $product->getPrice();
        $this->assertEquals(39.99, $result);
        $result = $product->getCategory();
        $this->assertEquals("T-Shirt", $result);
        $result = $product->getBrand();
        $this->assertEquals("nike", $result);
        $result = $product->getOrigin();
        $this->assertEquals("china", $result);
        $result = $product->getMaterials();
        $this->assertEquals('{"wool":"90%","plastic":"10%"}', $result);
        $result = $product->getDate();
        $this->assertEquals("2018-06-13", $result->format("Y-m-d"));
        $result = $product->getSex();
        $this->assertEquals("male", $result);

        $result = $product->getReview();
        $this->assertEquals("Review content", $result->getContent());
        $this->assertEquals(5, $result->getRating());

        $result = $product->getSize();
        $this->assertEquals("M", $result->getName());
        $this->assertEquals("15", $result->getSizeOne());
        $this->assertEquals("17", $result->getSizeTwo());
        $this->assertEquals("20", $result->getSizeThree());

        $result = $result->getColor();
        $this->assertEquals("blue", $result->getColor());
        $this->assertEquals(10, $result->getStock());

    }


}
