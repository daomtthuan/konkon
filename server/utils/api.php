<?php
namespace KonKon;

require_once __DIR__ . '/../controllers/user.php';
require_once __DIR__ . '/../utils/session.php';
require_once __DIR__ . '/http.php';

class Request {
  private $__data;

  public function __construct() {
    if (isset($_SERVER['CONTENT_TYPE'])) {
      if (strpos(strtolower($_SERVER['CONTENT_TYPE']), 'application/json') !== false) {
        $this->__data = json_decode(file_get_contents('php://input'), true);
      } else {
        $this->__data = null;
      }
    }
  }

  public function isJsonData() {
    return !is_null($this->__data);
  }

  public function isSetData(...$keys) {
    if (count($keys) > 0) {
      foreach ($keys as $key) {
        if (!isset($this->__data[$key])) {
          return false;
        }
      }
      return true;
    } else {
      return count($this->__data) > 0;
    }
  }

  public function getData(string $key = null) {
    return is_null($key) ? $this->__data : $this->__data[$key];
  }

  public function isSetParam(...$keys) {
    if (count($keys) > 0) {
      foreach ($keys as $key) {
        if (!isset($_GET[$key])) {
          return false;
        }
      }
      return true;
    } else {
      return count($_GET) > 0;
    }
  }

  public function getParam(string $key = null) {
    return is_null($key) ? $_GET : $_GET[$key];
  }

  public function isSetCookie(...$keys) {
    if (count($keys) > 0) {
      foreach ($keys as $key) {
        if (!isset($_COOKIE[$key])) {
          return false;
        }
      }
      return true;
    } else {
      return count($_COOKIE) > 0;
    }
  }

  public function getCookie(string $key = null) {
    return is_null($key) ? $_COOKIE : $_COOKIE[$key];
  }

  public function setCookie(string $key, string $value) {
    $_COOKIE[$key] = $value;
  }

  public function getUser() {
    if ($this->isSetCookie('auth_token_local', 'session')) {
      Session::getInstance()->start($this->getCookie('session'));
      if (Session::getInstance()->isSet('token')) {
        if (password_verify($token = Session::getInstance()->get('token'), $this->getCookie('auth_token_local'))) {
          $user = UserController::getInstance()->getById($token, -1, 1);
          if ($user['status'] != 0) {
            return $user;
          }
        }
      }
    }
    return null;
  }

  public function hasScope(string $scope) {
    $user = $this->getUser();
    if (!is_null($user)) {
      return in_array($scope, $user['scope']);
    }
    return false;
  }
}

class Response {
  public function __construct() {
    // HTTP::getInstance()->setAccessControl();
  }

  public function sendJson(string $data) {
    HTTP::getInstance()->setContentType("application/json; charset=UTF-8");
    $this->status(200, $data);
  }

  public function status(int $code, string $data = '') {
    HTTP::getInstance()->setStatus($code);
    echo $data;
    die;
  }
}

class Api {
  protected function _get(Request $request, Response $response) {
    $response->status(405);
  }

  protected function _post(Request $request, Response $response) {
    $response->status(405);
  }

  protected function _put(Request $request, Response $response) {
    $response->status(405);
  }

  protected function _delete(Request $request, Response $response) {
    $response->status(405);
  }

  public function __construct() {
    switch (strtolower($_SERVER['REQUEST_METHOD'])) {
    case 'get':
      $this->_get(new Request(), new Response());
      break;

    case 'post':
      $this->_post(new Request(), new Response());
      break;

    case 'put':
      $this->_put(new Request(), new Response());
      break;

    case 'delete':
      $this->_delete(new Request(), new Response());
      break;
    }
  }
}
