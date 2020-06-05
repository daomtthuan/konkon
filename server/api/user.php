<?php
namespace KonKon;

require_once __DIR__ . '/../controllers/user.php';
require_once __DIR__ . '/../utils/api.php';

new class extends Api {
  // protected function _get(Request $request, Response $response) {
  //   if ($request->hasScope('manager')) {
  //     if ($request->isSetParam('sort', 'page', 'per_page')) {
  //       $view = UserController::getInstance()->getView($request->getParam('sort'), $request->getParam('page'), $request->getParam('per_page'));
  //       if (!is_null($view)) {
  //         $response->sendJson(json_encode($view));
  //       } else {
  //         $response->status(400);
  //       }
  //     } else {
  //       $response->status(400);
  //     }
  //   } else {
  //     $response->status(401);
  //   }
  // }

  protected function _get(Request $request, Response $response) {
    if ($request->hasScope('manager')) {
      $response->sendJson(json_encode(UserController::getInstance()->getView()));
    } else {
      $response->status(401);
    }
  }

  protected function _post(Request $request, Response $response) {
    if ($request->isJsonData()) {
      if ($request->isSetData('account', 'password', 'email', 'name', 'gender', 'birthday', 'phone', 'address')) {
        $user = UserController::getInstance()->getByAccount($request->getData('account'), -1);
        if (is_null($user)) {
          if (UserController::getInstance()->add(
            $request->getData('account'),
            $request->getData('password'),
            $request->getData('email'),
            $request->getData('name'),
            $request->getData('gender'),
            $request->getData('birthday'),
            $request->getData('phone'),
            $request->getData('address')
          )) {
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
  }

  protected function _put(Request $request, Response $response) {
    if ($request->issetparam()) {
      $user = $request->getUser();
      if (!is_null($user)) {
        if ($request->isJsonData()) {
          switch ($request->getParam('mode')) {
          case 'information':
            if ($request->isSetData('email', 'name', 'gender', 'birthday', 'phone', 'address')) {
              if (UserController::getInstance()->set(
                $user['id'],
                $request->getData('email'),
                $request->getData('name'),
                $request->getData('gender'),
                $request->getData('birthday'),
                $request->getData('phone'),
                $request->getData('address')
              )) {
                if ($user['email'] != $request->getData('email')) {
                  if (UserController::getInstance()->setStatus($user['id'], 2)) {
                    $response->status(200);
                  } else {
                    $response->status(500);
                  }
                }
              } else {
                $response->status(400);
              }
            } else {
              $response->status(400);
            }
            break;

          case 'password':
            if ($request->isJsonData()) {
              if (UserController::getInstance()->setPassword(
                $user['id'],
                $user['password'],
                $request->getData('old'),
                $request->getData('new')
              )) {
                $response->status(200);
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
    } else {
      $response->status(400);
    }
  }
};
