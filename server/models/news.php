<?php
namespace KonKon;

class News {
  private $__data;
  public static $keys = [
    'id'     => [
      'name'   => 'news_id',
      'type'   => 's',
      'regex'  => 'id',
      'length' => 'id',
    ],
    'name'   => [
      'name'   => 'news_name',
      'type'   => 's',
      'regex'  => 'nameUrl',
      'length' => 'nameUrl',
    ],
    'status' => [
      'name'   => 'news_status',
      'type'   => 'i',
      'regex'  => 'number',
      'length' => 'status',
    ],
    'title'  => [
      'name'   => 'news_title',
      'type'   => 's',
      'regex'  => 'any',
      'length' => 'title',
    ],
    'date'   => [
      'name'   => 'news_date',
      'type'   => 's',
      'regex'  => 'date',
      'length' => 'date',
    ],
    'intro'  => [
      'name'   => 'news_intro',
      'type'   => 's',
      'regex'  => 'any',
      'length' => 'intro',
    ],
    'auth'   => [
      'name'   => 'news_auth',
      'type'   => 's',
      'regex'  => 'name',
      'length' => 'name',
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