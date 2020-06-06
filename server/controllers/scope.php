<?php
namespace KonKon;

require_once __DIR__ . '/../models/scope.php';
require_once __DIR__ . '/../utils/provider.php';

class ScopeController {
  private static $__instance = null;

  private function __construct() {}

  public static function getInstance(): ScopeController {
    if (is_null(self::$__instance)) {
      self::$__instance = new ScopeController();
    }
    return self::$__instance;
  }

  public function getView() {
    $scopes = [];
    foreach (Provider::getInstance()->executeQuery('select * from view_scope') as $data) {
      $scopes[] = Provider::getInstance()->modelToArray(new Scope($data));
    }
    return $scopes;
  }

  public function getById(string $id, int $status) {
    $query = Provider::getInstance()->getBindQuery(Scope::class, ['id' => $id, 'status' => $status]);
    if (!is_null($query)) {
      $datas = Provider::getInstance()->executeQuery('call getScopeById(?, ?)', $query['type'], ...$query['vars']);
      if (count($datas) == 1) {
        return Provider::getInstance()->modelToArray(new Scope($datas[0]));
      }
    }
    return null;
  }

  public function getByName(string $name, int $status) {
    $query = Provider::getInstance()->getBindQuery(Scope::class, ['name' => $name, 'status' => $status]);
    if (!is_null($query)) {
      $datas = Provider::getInstance()->executeQuery('call getScopeByName(?, ?)', $query['type'], ...$query['vars']);
      if (count($datas) == 1) {
        return Provider::getInstance()->modelToArray(new Scope($datas[0]));
      }
    }
    return null;
  }

  public function add(string $name, int $status) {
    $query = Provider::getInstance()->getBindQuery(Scope::class, [
      'name'   => $name,
      'status' => $status,
    ]);
    if (!is_null($query)) {
      $datas = Provider::getInstance()->executeQuery('call addScope(?, ?)', $query['type'], ...$query['vars']);
      if (count($datas) == 1) {
        return ['id' => $datas[0]['id']];
      }
    }
    return null;
  }

  public function set(string $id, string $name, string $status) {
    $query = Provider::getInstance()->getBindQuery(Scope::class, [
      'id'     => $id,
      'name'   => $name,
      'status' => $status,
    ]);
    if (!is_null($query)) {
      Provider::getInstance()->executeNonQuery('call setScope(?, ?, ?)', $query['type'], ...$query['vars']);
      return true;
    } else {
      return false;
    }
  }

  public function remove(string $id) {
    $query = Provider::getInstance()->getBindQuery(Scope::class, ['id' => $id]);
    if (!is_null($query)) {
      Provider::getInstance()->executeNonQuery('call deleteScope(?)', $query['type'], ...$query['vars']);
      return true;
    } else {
      return false;
    }
  }
}