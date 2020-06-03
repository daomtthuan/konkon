<?php
namespace KonKon;

class Brand {
  private $__data;
  public static $keys = [
    'id'     => [
      'name'   => 'brand_id',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
    ],
    'name'   => [
      'name'   => 'brand_name',
      'type'   => 's',
      'regex'  => 'name',
      'length' => 'name',
    ],
    'status' => [
      'name'   => 'brand_status',
      'type'   => 'i',
      'regex'  => 'number',
      'length' => 'status',
    ],
  ];

  public function __construct(array $data) {
    $this->__data = $data;
  }

  public function isSetData(string $key) {
    return isset($this->__data[$key]);
  }

  public function getData(string $key) {
    return $this->__data[$key];
  }
}