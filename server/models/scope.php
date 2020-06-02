<?php
namespace KonKon;

class Scope {
  private $__data;
  public static $keys = [
    'id'     => [
      'name'   => 'scope_id',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
    ],
    'name'   => [
      'name'   => 'scope_name',
      'type'   => 's',
      'regex'  => 'name',
      'length' => 'name',
    ],
    'status' => [
      'name'   => 'scope_status',
      'type'   => 'i',
      'regex'  => 'number',
      'length' => 'status',
    ],
  ];

  public function __construct(array $data) {
    $this->__data = $data;
  }

  public function getData(string $key) {
    return $this->__data[$key];
  }
}