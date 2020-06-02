<?php
namespace KonKon;

require_once __DIR__ . '/../models/scope.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../utils/provider.php';

class UserScopeController {
  private static $__instance = null;

  private function __construct() {}

  public static function getInstance(): UserScopeController {
    if (is_null(self::$__instance)) {
      self::$__instance = new UserScopeController();
    }
    return self::$__instance;
  }

  public function getScope(string $userId, int $status) {
    $query = Provider::getInstance()->getBindQuery(User::class, ['id' => $userId, 'status' => $status]);
    if (!is_null($query)) {
      $scopes = [];
      foreach (Provider::getInstance()->executeQuery('call getUserScopeByUserId(?, ?)', $query['type'], ...$query['vars']) as $data) {
        $scopes[] = (Provider::getInstance()->modelToArray(new Scope($data)))['name'];
      }
      return $scopes;
    }
    return null;
  }
}