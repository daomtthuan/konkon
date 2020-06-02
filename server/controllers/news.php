<?php
namespace KonKon;

require_once __DIR__ . '/../models/news.php';
require_once __DIR__ . '/../utils/provider.php';

class NewsController {
  private static $__instance = null;

  private function __construct() {}

  public static function getInstance(): NewsController {
    if (is_null(self::$__instance)) {
      self::$__instance = new NewsController();
    }
    return self::$__instance;
  }

  public function getByPage(string $page, int $status) {
    if (is_numeric($page)) {
      if ($page > 0) {
        $query = Provider::getInstance()->getBindQuery(News::class, ['status' => $status]);
        if (!is_null($query)) {
          $posts = [];
          foreach (Provider::getInstance()->executeQuery("call getNewsByPage($page, ?)", $query['type'], ...$query['vars']) as $data) {
            $posts[] = Provider::getInstance()->modelToArray(new News($data));
          }
          return $posts;
        }
      }
    }
    return null;
  }

  public function getByName(string $name, int $status) {
    $query = Provider::getInstance()->getBindQuery(News::class, ['name' => $name, 'status' => $status]);
    if (!is_null($query)) {
      $datas = Provider::getInstance()->executeQuery("call getNewsByName(?, ?)", $query['type'], ...$query['vars']);
      if (count($datas) == 1) {
        return Provider::getInstance()->modelToArray(new News($datas[0]));
      }
    }
    return null;
  }
}