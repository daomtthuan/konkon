<?php
namespace KonKon;

require_once __DIR__ . '/../controllers/category-group.php';
require_once __DIR__ . '/../utils/api.php';

new class extends Api {
  protected function _get(Request $request, Response $response) {
    if ($request->issetparam()) {
      if ($request->isSetParam('status')) {
        switch ($request->getParam('status')) {
        case 1:
          $categoryGroups = CategoryGroupController::getInstance()->get(1);
          if (!is_null($categoryGroups)) {
            $response->sendJson(json_encode($categoryGroups));
          } else {
            $response->status(400);
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
