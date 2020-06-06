<?php
namespace KonKon;

require_once __DIR__ . '/../../controllers/scope.php';
require_once __DIR__ . '/../../utils/api.php';

new class extends Api {
  protected function _get(Request $request, Response $response) {
    if ($request->hasScope('manager')) {
      $response->sendJson(json_encode(ScopeController::getInstance()->getView()));
    } else {
      $response->status(401);
    }
  }

  protected function _post(Request $request, Response $response) {
    if ($request->hasScope('manager')) {
      if ($request->isJsonData()) {
        if ($request->isSetData('name', 'status')) {
          if (is_null(ScopeController::getInstance()->getByName($request->getData('name'), -1))) {
            $scope = ScopeController::getInstance()->add(
              $request->getData('name'),
              $request->getData('status')
            );
            if (!is_null($scope)) {
              $response->sendJson(json_encode($scope));
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
        if ($request->isSetData('id', 'name', 'status')) {
          $scope = ScopeController::getInstance()->getById($request->getData('id'), -1);
          if (!is_null($scope)) {
            if (ScopeController::getInstance()->set($scope['id'], $request->getData('name'), $request->getData('status'))) {
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

  protected function _delete(Request $request, Response $response) {
    if ($request->hasScope('manager')) {
      if ($request->isSetParam('id')) {
        $scope = ScopeController::getInstance()->getById($request->getParam('id'), -1);
        if (!is_null($scope)) {
          if (ScopeController::getInstance()->remove($scope['id'])) {
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
