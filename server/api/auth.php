<?php
namespace KonKon;

require_once __DIR__ . '/../utils/api.php';
require_once __DIR__ . '/../utils/session.php';

new class extends Api {
  protected function _get(Request $request, Response $response) {
    $user = $request->getUser();
    if (!is_null($user)) {
      unset($user['password']);
      $response->sendJson(json_encode(['user' => $user]));
    } else {
      $response->status(401);
    }
  }

  protected function _post(Request $request, Response $response) {
    if ($request->isJsonData()) {
      if ($request->isSetData('account', 'password')) {
        $id = UserController::getInstance()->auth($request->getData('account'), $request->getData('password'));
        if (!is_null($id)) {
          if ($id) {
            Session::getInstance()->start($request->isSetCookie('session') ? $request->getCookie('session') : null);
            Session::getInstance()->set("token", $id);
            $response->sendJson(json_encode(['token' => password_hash($id, PASSWORD_BCRYPT)]));
          } else {
            $response->status(401);
          }
        } else {
          $response->status(400);
        }
      } else {
        $response->status(400);
      }
    } else {
      $response->status(415);
    }
  }

  protected function _delete(Request $request, Response $response) {
    $user = $request->getUser();
    if (!is_null($user)) {
      if ($request->isSetCookie('session')) {
        Session::getInstance()->start($request->getCookie('session'));
        Session::getInstance()->remove("token");
        $response->status(200);
      } else {
        $response->status(401);
      }
    } else {
      $response->status(401);
    }
  }
};
