<?php
namespace KonKon;

class Category {
  private $__data;
  public static $keys = [
    'id'            => [
      'name'   => 'category_id',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
    ],
    'name'          => [
      'name'   => 'category_name',
      'type'   => 's',
      'regex'  => 'name',
      'length' => 'name',
    ],
    'status'        => [
      'name'   => 'category_status',
      'type'   => 'i',
      'regex'  => 'number',
      'length' => 'status',
    ],
    'categoryGroup' => [
      'name'   => 'category_categoryGroup',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
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