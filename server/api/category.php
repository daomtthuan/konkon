<?php
namespace KonKon;

require_once __DIR__ . '/../controllers/category.php';
require_once __DIR__ . '/../utils/api.php';

new class extends Api {
  protected function _get(Request $request, Response $response) {
    if ($request->issetparam()) {
      if ($request->isSetParam('status', 'categoryGroupId')) {
        switch ($request->getParam('status')) {
        case 1:
          $categories = CategoryController::getInstance()->getByCategoryGroupId($request->getParam('categoryGroupId'));
          if (!is_null($categories)) {
            $response->sendJson(json_encode($categories));
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
