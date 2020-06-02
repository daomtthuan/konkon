<?php
namespace KonKon;

class Product {
  private $__data;
  public static $keys = [
    'id'       => [
      'name'   => 'product_id',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
    ],
    'name'     => [
      'name'   => 'product_name',
      'type'   => 's',
      'regex'  => 'name',
      'length' => 'name',
    ],
    'status'   => [
      'name'   => 'product_status',
      'type'   => 'i',
      'regex'  => 'number',
      'length' => 'status',
    ],
    'price'    => [
      'name'   => 'product_price',
      'type'   => 'i',
      'regex'  => 'number',
      'length' => 'price',
    ],
    'quantity' => [
      'name'   => 'product_quantity',
      'type'   => 'i',
      'regex'  => 'number',
      'length' => 'quantity',
    ],
    'category' => [
      'name'   => 'product_category',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
    ],
    'brand'    => [
      'name'   => 'product_brand',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
    ],
  ];

  public function __construct(array $data) {
    $this->__data = $data;
  }

  public function getData(string $key) {
    return $this->__data[$key];
  }
}