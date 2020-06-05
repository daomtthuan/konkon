<?php
namespace KonKon;

require_once __DIR__ . '/../utils/api.php';
require_once __DIR__ . '/../utils/mail.php';
require_once __DIR__ . '/../utils/session.php';

new class extends Api {
  protected function _get(Request $request, Response $response) {
    $user = $request->getUser();
    if (!is_null($user)) {
      if ($user['status'] == 2) {
        $code = time();
        if (Session::getInstance()->isSet('verifyCode')) {
          if ($code - Session::getInstance()->get('verifyCode') < 120) {
            $response->status(400);
          }
        }

        if (Mail::getInstance()->sendHtml($user['email'], $user['name'], "Verification code",
          '<p>' .
          '  Your verification code:<br>' .
          '  <b>' . ($code % 100000) . '</b>' .
          '</p>')
        ) {
          Session::getInstance()->set('verifyCode', $code);
          $response->status(200);
        } else {
          $response->status(400);
        }
      } else {
        $response->status(400);
      }
    } else {
      $response->status(401);
    }
  }

  protected function _post(Request $request, Response $response) {
    $user = $request->getUser();
    if (!is_null($user)) {
      if ($request->isJsonData()) {
        if ($request->isSetData('code')) {
          if (Session::getInstance()->get('verifyCode') % 100000 == $request->getData('code')) {
            if (UserController::getInstance()->setStatus($user['id'], 1)) {
              $response->status(200);
            } else {
              $response->status(400);
            }
          } else {
            $response->status(406);
          }
        } else {
          $response->status(400);
        }
      } else {
        $response->status(415);
      }
    } else {
      $response->status(401);
    }
  }
};