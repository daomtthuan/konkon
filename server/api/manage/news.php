<?php
namespace KonKon;

require_once __DIR__ . '/../../controllers/news.php';
require_once __DIR__ . '/../../utils/api.php';

new class extends Api {
  protected function _get(Request $request, Response $response) {
    if ($request->hasScope('manager')) {
      $response->sendJson(json_encode(NewsController::getInstance()->getView()));
    } else {
      $response->status(401);
    }
  }

  protected function _post(Request $request, Response $response) {
    $user = $request->getUser();
    if (!is_null($user)) {
      if (in_array('manager', $user['scope'])) {
        switch ($request->getParam('mode')) {
        case 'information':
          if ($request->isJsonData()) {
            if ($request->isSetData('name', 'title', 'date', 'intro', 'content', 'status')) {
              if (is_null(NewsController::getInstance()->getByName($request->getData('name'), -1))) {
                $news = NewsController::getInstance()->add(
                  $request->getData('name'),
                  $request->getData('title'),
                  $request->getData('date'),
                  $request->getData('intro'),
                  $user['id'],
                  $request->getData('content'),
                  $request->getData('status')
                );
                if (!is_null($news)) {
                  $response->sendJson(json_encode($news));
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
          break;

        case 'image':
          if ($request->isSetParam('name')) {
            if (NewsController::getInstance()->uploadImage($request->getParam('name'))) {
              $response->status(200);
            } else {
              $response->status(500);
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
        $response->status(401);
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
