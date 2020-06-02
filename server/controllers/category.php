<?php
namespace KonKon;

require_once __DIR__ . '/../models/category-group.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../utils/provider.php';

class CategoryController {
  private static $__instance = null;

  private function __construct() {}

  public static function getInstance(): CategoryController {
    if (is_null(self::$__instance)) {
      self::$__instance = new CategoryController();
    }
    return self::$__instance;
  }

  public function getByCategoryGroupId(string $categoryGroupId, int $status) {
    $query1 = Provider::getInstance()->getBindQuery(CategoryGroup::class, ['id' => $categoryGroupId]);
    $query2 = Provider::getInstance()->getBindQuery(Category::class, ['status' => $status]);
    if (!is_null($query1) && !is_null($query2)) {
      $categories = [];
      foreach (Provider::getInstance()->executeQuery('call getCategoryByCategoryGroupId(?, ?)', $query1['type'] . $query2['type'], ...$query1['vars'], ...$query2['vars']) as $data) {
        $categories[] = Provider::getInstance()->modelToArray(new Category($data));
      }
      return $categories;
    }
    return null;
  }
}