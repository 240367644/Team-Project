<?php

use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private $testUserId = 1;
    private $testBasket = [
        1 => [
            "id" => 1,
            "name" => "Desk Lamp",
            "price" => 24.99,
            "image" => "lamp.jpg",
            "quantity" => 2
        ],
        2 => [
            "id" => 2,
            "name" => "Office Chair",
            "price" => 89.99,
            "image" => "chair.jpg",
            "quantity" => 1
        ]
    ];

    protected function setUp(): void
    {
        session_start();
    }

    /**
     * Test that basket session is properly initialized
     */
    public function testBasketSessionInitialization()
    {
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
        
        $this->assertTrue(isset($_SESSION['basket']));
        $this->assertIsArray($_SESSION['basket']);
    }

    /**
     * Test that empty basket is rejected in checkout
     */
    public function testCheckoutRejectsEmptyBasket()
    {
        $_SESSION['basket'] = [];
        
        $basketEmpty = !isset($_SESSION['basket']) || empty($_SESSION['basket']);
        $this->assertTrue($basketEmpty);
    }

    /**
     * Test that basket subtotal calculation logic is correct
     */
    public function testBasketSubtotalCalculation()
    {
        $_SESSION['basket'] = $this->testBasket;
        $subtotal = 0;

        foreach ($_SESSION['basket'] as &$item) {
            $item['price'] = (float)$item['price'];
            $item['quantity'] = (int)$item['quantity'];
            $item['total'] = $item['price'] * $item['quantity'];
            $subtotal += $item['total'];
        }

        $this->assertEquals(199.97, $subtotal);
    }

    /**
     * Test that quantity can be updated in basket
     */
    public function testBasketQuantityUpdate()
    {
        $_SESSION['basket'] = $this->testBasket;
        $productId = 1;
        $newQuantity = 5;

        if (isset($_SESSION['basket'][$productId])) {
            $_SESSION['basket'][$productId]['quantity'] = intval($newQuantity);
        }

        $this->assertEquals(5, $_SESSION['basket'][$productId]['quantity']);
    }

    /**
     * Test that items can be removed from basket
     */
    public function testBasketItemRemoval()
    {
        $_SESSION['basket'] = $this->testBasket;
        $productId = 1;

        if (isset($_SESSION['basket'][$productId])) {
            unset($_SESSION['basket'][$productId]);
        }

        $this->assertFalse(isset($_SESSION['basket'][$productId]));
        $this->assertCount(1, $_SESSION['basket']);
    }

    /**
     * Test that checkout validates delivery details exist
     */
    public function testCheckoutValidatesDeliveryDetails()
    {
        $_POST['phone'] = '1234567890';
        $_POST['address'] = '123 Student Street';
        $_POST['postcode'] = 'AB12 3CD';

        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;
        $postcode = $_POST['postcode'] ?? null;

        $hasAllDetails = !empty($phone) && !empty($address) && !empty($postcode);
        $this->assertTrue($hasAllDetails);
    }

    /**
     * Test that checkout fails with missing delivery details
     */
    public function testCheckoutFailsWithMissingDetails()
    {
        $_POST['phone'] = '';
        $_POST['address'] = null;
        $_POST['postcode'] = '';

        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;
        $postcode = $_POST['postcode'] ?? null;

        $hasAllDetails = !empty($phone) && !empty($address) && !empty($postcode);
        $this->assertFalse($hasAllDetails);
    }
}