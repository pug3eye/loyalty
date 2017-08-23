<?php namespace App;

  class SaleProduct {

    private $product_id;
    private $product_barcode;
    private $name;
    private $quantity;
    private $price;
    private $point;
    private $has_promotion_price;
    private $has_promotion_point;

    function __construct() {
      $this->product_id = NULL;
      $this->product_barcode = NULL;
      $this->name = NULL;
      $this->quantity = NULL;
      $this->price = NULL;
      $this->point = NULL;
      $this->has_promotion_price = false;
      $this->has_promotion_point = false;
    }

    // getter function.

    function getProductId() {
      return $this->product_id;
    }

    function getProductBarcode() {
      return $this->product_barcode;
    }

    function getName() {
      return $this->name;
    }

    function getQuantity() {
      return $this->quantity;
    }

    function getPrice() {
      return $this->price;
    }

    function getPoint() {
      return $this->point;
    }

    function getHasPromotionPrice() {
      return $this->has_promotion_price;
    }

    function getHasPromotionPoint() {
      return $this->has_promotion_point;
    }

    // end getter function.

    // setter function.

    function setProductId($value) {
      $this->product_id = $value;
    }

    function setProductBarcode($value) {
      $this->product_barcode = $value;
    }

    function setName($value) {
      $this->name = $value;
    }

    function setQuantity($value) {
      $this->quantity = $value;
    }

    function setPrice($value) {
      $this->price = $value;
    }

    function setPoint($value) {
      $this->point = $value;
    }

    function setHasPromotionPrice($value) {
      $this->has_promotion_price = $value;
    }

    function setHasPromotionPoint($value) {
      $this->has_promotion_point = $value;
    }

    // end setter function.

  }

?>
