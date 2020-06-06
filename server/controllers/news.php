<?php
namespace KonKon;

require_once __DIR__ . '/../models/user.php';
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

  public function getView() {
    $posts = [];
    foreach (Provider::getInstance()->executeQuery('select * from view_news') as $data) {
      $post = Provider::getInstance()->modelToArray(new News($data));
      if ($content = Provider::getInstance()->readFile(__DIR__ . '/../assets/news/contents/' . $post['name'] . '.html')) {
        $post['content'] = $content;
      } else {
        $post['content'] = '';
      }
      $posts[] = $post;
    }
    return $posts;
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

  public function getById(string $id, int $status) {
    $query = Provider::getInstance()->getBindQuery(News::class, ['id' => $id, 'status' => $status]);
    if (!is_null($query)) {
      $datas = Provider::getInstance()->executeQuery("call getNewsById(?, ?)", $query['type'], ...$query['vars']);
      if (count($datas) == 1) {
        return Provider::getInstance()->modelToArray(new News($datas[0]));
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

  public function add(string $name, string $title, string $date, string $intro, string $auth, string $content, int $status) {
    $query1 = Provider::getInstance()->getBindQuery(News::class, [
      'name'  => $name,
      'title' => $title,
      'date'  => $date,
      'intro' => $intro,
    ]);
    $query2 = Provider::getInstance()->getBindQuery(User::class, ['id' => $auth]);
    $query3 = Provider::getInstance()->getBindQuery(News::class, ['status' => $status]);

    if (!is_null($query1) && !is_null($query2) && !is_null($query3)) {
      $datas = Provider::getInstance()->executeQuery('call addNews(?, ?, ?, ?, ?, ?)', $query1['type'] . $query2['type'] . $query3['type'], ...$query1['vars'], ...$query2['vars'], ...$query3['vars']);
      if (count($datas) == 1) {
        if (Provider::getInstance()->writeFile($content, __DIR__ . "/../assets/news/contents/$name.html")) {
          return ['id' => $datas[0]['id']];
        }
      }
    }
    return null;
  }

  public function set(string $id, string $name, string $title, string $date, string $intro, string $content, int $status) {
    $query = Provider::getInstance()->getBindQuery(News::class, [
      'id'     => $id,
      'name'   => $name,
      'title'  => $title,
      'date'   => $date,
      'intro'  => $intro,
      'status' => $status,
    ]);
    if (!is_null($query)) {
      Provider::getInstance()->executeNonQuery('call setNews(?, ?, ?, ?, ?, ?)', $query['type'], ...$query['vars']);
      if (Provider::getInstance()->writeFile($content, __DIR__ . "/../assets/news/contents/$name.html")) {
        return true;
      }
    } else {
      return false;
    }
  }

  public function uploadImage(string $name) {
    return Provider::getInstance()->uploadFile(__DIR__ . "/../assets/news/images/$name.jpg");
  }

  public function rename(string $old, string $new) {
    return
    Provider::getInstance()->renameFile(__DIR__ . "/../assets/news/images/$old.jpg", __DIR__ . "/../assets/news/images/$new.jpg") &&
    Provider::getInstance()->renameFile(__DIR__ . "/../assets/news/contents/$old.html", __DIR__ . "/../assets/news/contents/$new.html");
  }
}