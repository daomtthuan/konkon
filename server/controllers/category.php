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

  public function getByCategoryGroupId(string $categoryGroupId) {
    $query = Provider::getInstance()->getBindQuery(CategoryGroup::class, ['id' => $categoryGroupId]);
    if (!is_null($query)) {
      $categories = [];
      foreach (Provider::getInstance()->executeQuery('call getCategoryByCategoryGroupId(?)', $query['type'], ...$query['vars']) as $data) {
        $categories[] = Provider::getInstance()->modelToArray(new Category($data));
      }
      return $categories;
    }
    return null;
  }
}