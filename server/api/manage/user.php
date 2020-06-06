<?php
namespace KonKon;

require_once __DIR__ . '/../../controllers/user.php';
require_once __DIR__ . '/../../utils/api.php';

new class extends Api {
  protected function _get(Request $request, Response $response) {
    if ($request->hasScope('manager')) {
      $response->sendJson(json_encode(UserController::getInstance()->getView()));
    } else {
      $response->status(401);
    }
  }

  protected function _post(Request $request, Response $response) {
    if ($request->hasScope('manager')) {
      if ($request->isJsonData()) {
        if ($request->isSetData('account', 'email', 'name', 'gender', 'birthday', 'phone', 'address', 'status')) {
          if (is_null(UserController::getInstance()->getByAccount($request->getData('account'), -1))) {
            $user = UserController::getInstance()->addWithStatus(
              $request->getData('account'),
              $request->getData('email'),
              $request->getData('name'),
              $request->getData('gender'),
              $request->getData('birthday'),
              $request->getData('phone'),
              $request->getData('address'),
              $request->getData('status')
            );
            if (!is_null($user)) {
              $response->sendJson(json_encode($user));
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

  protected function _put(Request $request, Response $response) {
    if ($request->hasScope('manager')) {
      if ($request->isJsonData()) {
        switch ($request->getParam('mode')) {
        case 'information':
          if ($request->isSetData('id', 'email', 'name', 'gender', 'birthday', 'phone', 'address', 'status')) {
            $user = UserController::getInstance()->getById($request->getData('id'), -1);
            if (!is_null($user)) {
              if (UserController::getInstance()->set(
                $user['id'],
                $request->getData('email'),
                $request->getData('name'),
                $request->getData('gender'),
                $request->getData('birthday'),
                $request->getData('phone'),
                $request->getData('address')
              )) {
                if (UserController::getInstance()->setStatus($user['id'], $request->getData('status'))) {
                  $response->status(200);
                } else {
                  $response->status(400);
                }
              } else {
                $response->status(400);
              }
            } else {
              $response->status(400);
            }
          } else {
            $response->status(400);
          }
          break;

        case 'password':
          if ($request->isSetData('id')) {
            $user = UserController::getInstance()->getById($request->getData('id'), -1);
            if (!is_null($user)) {
              $password = UserController::getInstance()->resetPassword($user['id']);
              if (!is_null($password)) {
                $response->sendJson(json_encode(['password' => $password]));
              } else {
                $response->status(400);
              }
            } else {
              $response->status(400);
            }
          } else {
            $response->status(400);
          }
          break;

        default:
          $response->status(400);
          break;
        }
      } else {
        $response->status(415);
      }
    } else {
      $response->status(401);
    }
  }

  protected function _delete(Request $request, Response $response) {
    if ($request->hasScope('manager')) {
      if ($request->isSetParam('id')) {
        $user = UserController::getInstance()->getById($request->getParam('id'), -1);
        if (!is_null($user)) {
          if (UserController::getInstance()->remove($user['id'])) {
            $response->status(200);
          } else {
            $response->status(400);
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
