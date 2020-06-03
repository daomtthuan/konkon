<?php
namespace KonKon;

class CategoryGroup {
  private $__data;
  public static $keys = [
    'id'     => [
      'name'   => 'categoryGroup_id',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
    ],
    'name'   => [
      'name'   => 'categoryGroup_name',
      'type'   => 's',
      'regex'  => 'name',
      'length' => 'name',
    ],
    'status' => [
      'name'   => 'categoryGroup_status',
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