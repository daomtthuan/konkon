<?php
namespace KonKon;

class User {
  private $__data;
  public static $keys = [
    'id'       => [
      'name'   => 'user_id',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
    ],
    'account'  => [
      'name'   => 'user_account',
      'type'   => 's',
      'regex'  => 'account',
      'length' => 'account',
    ],
    'password' => [
      'name'   => 'user_password',
      'type'   => 's',
      'regex'  => 'any',
      'length' => 'password',
    ],
    'email'    => [
      'name'   => 'user_email',
      'type'   => 's',
      'regex'  => 'email',
      'length' => 'email',
    ],
    'status'   => [
      'name'   => 'user_status',
      'type'   => 'i',
      'regex'  => 'number',
      'length' => 'status',
    ],
    'name'     => [
      'name'   => 'user_name',
      'type'   => 's',
      'regex'  => 'name',
      'length' => 'name',
    ],
    'gender'   => [
      'name'   => 'user_gender',
      'type'   => 'i',
      'regex'  => 'number',
      'length' => 'gender',
    ],
    'birthday' => [
      'name'   => 'user_birthday',
      'type'   => 's',
      'regex'  => 'date',
      'length' => 'date',
    ],
    'phone'    => [
      'name'   => 'user_phone',
      'type'   => 's',
      'regex'  => 'phone',
      'length' => 'phone',
    ],
    'address'  => [
      'name'   => 'user_address',
      'type'   => 's',
      'regex'  => 'any',
      'length' => 'address',
    ],
  ];

  public function __construct(array $data) {
    $this->__data = $data;
  }

  public function getData(string $key) {
    return $this->__data[$key];
  }
}