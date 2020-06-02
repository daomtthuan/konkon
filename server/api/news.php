<?php
namespace KonKon;

require_once __DIR__ . '/../controllers/news.php';
require_once __DIR__ . '/../utils/api.php';

new class extends Api {
  protected function _get(Request $request, Response $response) {
    if ($request->issetparam()) {
      if ($request->isSetParam('name', 'status')) {
        switch ($request->getParam('status')) {
        case 1:
          $posts = NewsController::getInstance()->getByName($request->getParam('name'), 1);
          if (!is_null($posts)) {
            $response->sendJson(json_encode($posts));
          } else {
            $response->status(404);
          }
          break;

        default:
          $response->status(400);
          break;
        }
      } elseif ($request->isSetParam('page', 'status')) {
        switch ($request->getParam('status')) {
        case 1:
          $posts = NewsController::getInstance()->getByPage($request->getParam('page'), 1);
          if (!is_null($posts)) {
            $response->sendJson(json_encode($posts));
          } else {
            $response->status(500);
          }
          break;

        default:
          $response->status(400);
          break;
        }
      } else {
        $response->status(400);
      }
    } else {
      $response->status(400);
    }
  }
};
