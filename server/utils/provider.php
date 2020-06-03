<?php
namespace KonKon;

require_once __DIR__ . '/../utils/http.php';
require_once __DIR__ . '/../utils/regex.php';
require_once __DIR__ . '/../utils/vendor.php';

class Provider {
  private static $__instance = null;

  private function __construct() {}

  public static function getInstance(): Provider {
    if (is_null(self::$__instance)) {
      self::$__instance = new Provider();
    }
    return self::$__instance;
  }

  public function executeQuery(string $query, string $type = null, ...$vars) {
    $connection = @new \mysqli(getenv('database_host'), getenv('database_user'), getenv('database_password'), getenv('database_name'), getenv('database_port'));

    if ($connection->connect_error) {
      HTTP::getInstance()->setStatus(500);
      die('Connect database failed');
    } else {
      $statement = $connection->prepare($query);
      if (!is_null($type)) {
        $statement->bind_param($type, ...$vars);
      }
      if ($statement->execute()) {
        $result = $statement->get_result();
        $data   = [];
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
        $connection->close();
        return $data;
      } else {
        $connection->close();
        HTTP::getInstance()->setStatus(500);
        die('Execute query failed');
      }
    }
  }

  public function executeNonQuery(string $query, string $type = null, ...$vars) {
    $connection = @new \mysqli(getenv('database_host'), getenv('database_user'), getenv('database_password'), getenv('database_name'), getenv('database_port'));

    if ($connection->connect_error) {
      HTTP::getInstance()->setStatus(500);
      die('Lỗi kết nối cơ sở dữ liệu');
    } else {
      $statement = $connection->prepare($query);
      if (!is_null($type)) {
        $statement->bind_param($type, ...$vars);
      }
      $result = $statement->execute();
      $connection->close();
      if (!$result) {
        $connection->close();
        HTTP::getInstance()->setStatus(500);
        die('Execute query failed');
      }
    }
  }

  public function getBindQuery($modelClass, array $params) {
    $result = ['type' => '', 'vars' => []];
    if (count($params) > 0) {
      foreach ($params as $key => $value) {
        if (Regex::getInstance()->test($modelClass::$keys[$key]['regex'], $modelClass::$keys[$key]['length'], $value)) {
          $result['type'] .= $modelClass::$keys[$key]['type'];
          $result['vars'][] = $value;
        } else {
          return null;
        }
      }
    }
    return $result;
  }

  public function modelToArray($model) {
    $result = [];
    foreach ($model::$keys as $key => $value) {
      if ($model->isSetData($value['name'])) {
        $result[$key] = $model->getData($value['name']);
      }
    }
    return $result;
  }
}