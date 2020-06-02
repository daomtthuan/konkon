<?php
namespace KonKon;

require_once __DIR__ . '/../models/category-group.php';
require_once __DIR__ . '/../utils/provider.php';

class CategoryGroupController {
  private static $__instance = null;

  private function __construct() {}

  public static function getInstance(): CategoryGroupController {
    if (is_null(self::$__instance)) {
      self::$__instance = new CategoryGroupController();
    }
    return self::$__instance;
  }

  public function get(int $status) {
    $query = Provider::getInstance()->getBindQuery(CategoryGroup::class, ['status' => $status]);
    if (!is_null($query)) {
      $categoryGroups = [];
      foreach (Provider::getInstance()->executeQuery('call getCategoryGroup(?)', $query['type'], ...$query['vars']) as $data) {
        $categoryGroups[] = Provider::getInstance()->modelToArray(new CategoryGroup($data));
      }
      return $categoryGroups;
    }
    return null;
  }
}