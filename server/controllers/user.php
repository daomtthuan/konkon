<?php
namespace KonKon;

require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../utils/provider.php';
require_once __DIR__ . '/user-scope.php';

class UserController {
  private static $__instance = null;

  private function __construct() {}

  public static function getInstance(): UserController {
    if (is_null(self::$__instance)) {
      self::$__instance = new UserController();
    }
    return self::$__instance;
  }

  public function auth(string $account, string $password) {
    $user = $this->getByAccount($account, -1);
    if (!is_null($user)) {
      return $user ? (password_verify($password, $user['password']) ? (string)$user['id'] : false) : false;
    }
    return null;
  }

  public function get() {
    $users = [];
    foreach (Provider::getInstance()->executeQuery('select * from view_user') as $data) {
      $users[] = Provider::getInstance()->modelToArray(new User($data));
    }
    return $users;
  }

  public function getById(string $id, int $status, int $scopeStatus) {
    $query = Provider::getInstance()->getBindQuery(User::class, ['id' => $id, 'status' => $status]);
    if (!is_null($query)) {
      $datas = Provider::getInstance()->executeQuery('call getUserById(?, ?)', $query['type'], ...$query['vars']);
      if (count($datas) == 1) {
        $user   = Provider::getInstance()->modelToArray(new User($datas[0]));
        $scopes = UserScopeController::getInstance()->getScope($id, $scopeStatus);
        if (!is_null($scopes)) {
          $user['scope'] = $scopes;
          return $user;
        }
      }
    }
    return null;
  }

  public function getByAccount(string $account, int $status) {
    $query = Provider::getInstance()->getBindQuery(User::class, ['account' => $account, 'status' => $status]);
    if (!is_null($query)) {
      $datas = Provider::getInstance()->executeQuery('call getUserByAccount(?, ?)', $query['type'], ...$query['vars']);
      if (count($datas) == 1) {
        return Provider::getInstance()->modelToArray(new User($datas[0]));
      }
    }
    return null;
  }

  public function add(string $account, string $password, string $email, string $name, string $gender, string $birthday, string $phone, string $address) {
    $query = Provider::getInstance()->getBindQuery(User::class, [
      'account'  => $account,
      'password' => password_hash($password, PASSWORD_BCRYPT),
      'email'    => $email,
      'name'     => $name,
      'gender'   => $gender,
      'birthday' => $birthday,
      'phone'    => $phone,
      'address'  => $address,
    ]);
    if (!is_null($query)) {
      Provider::getInstance()->executeNonQuery('call addUser(?, ?, ?, ?, ?, ?, ?, ?)', $query['type'], ...$query['vars']);
      return true;
    } else {
      return false;
    }
  }

  public function set(string $id, string $email, string $name, string $gender, string $birthday, string $phone, string $address) {
    $query = Provider::getInstance()->getBindQuery(User::class, [
      'id'       => $id,
      'email'    => $email,
      'name'     => $name,
      'gender'   => $gender,
      'birthday' => $birthday,
      'phone'    => $phone,
      'address'  => $address,
    ]);
    if (!is_null($query)) {
      Provider::getInstance()->executeNonQuery('call setUser(?, ?, ?, ?, ?, ?, ?)', $query['type'], ...$query['vars']);
      return true;
    } else {
      return false;
    }
  }

  public function setPassword(string $id, string $hash, string $old, string $new) {
    if (password_verify($old, $hash)) {
      $query = Provider::getInstance()->getBindQuery(User::class, [
        'id'       => $id,
        'password' => password_hash($new, PASSWORD_BCRYPT),
      ]);
      if (!is_null($query)) {
        Provider::getInstance()->executeNonQuery('call setPasswordUser(?, ?)', $query['type'], ...$query['vars']);
        return true;
      }
    }
    return false;
  }

  public function setStatus(string $id, int $status) {
    $query = Provider::getInstance()->getBindQuery(User::class, [
      'id'     => $id,
      'status' => $status,
    ]);
    if (!is_null($query)) {
      Provider::getInstance()->executeNonQuery('call setStatusUser(?, ?)', $query['type'], ...$query['vars']);
      return true;
    } else {
      return false;
    }
  }
}