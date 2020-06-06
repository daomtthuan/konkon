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

  public function getOrderQuery($modelClass, string $sort) {
    if ($sort != "") {
      $explode = explode("|", $sort);
      if (count($explode) == 2) {
        if ($explode[1] == 'desc' || $explode[1] == 'asc') {
          if (isset($modelClass::$keys[$explode[0]])) {
            return 'order by ' . $modelClass::$keys[$explode[0]]['name'] . ' ' . $explode[1];
          }
        }
      }
      return null;
    } else {
      return '';
    }
  }

  public function getLimitQuery(string $page, string $perPage) {
    if (is_numeric($page) && is_numeric($perPage)) {
      return 'limit ' . ($page * $perPage - $perPage) . ", $perPage";
    }
    return null;
  }

  public function getViewData(int $total, string $url, string $sort, array $data, int $page, string $perPage) {
    $last = ceil($total / $perPage);
    $from = $page * $perPage - $perPage + 1;
    $to   = $from + $perPage - 1;

    $result = [
      'total'        => $total,
      'per_page'     => $perPage,
      'current_page' => $page,
      'last_page'    => $last,
      'from'         => $from,
      'to'           => $to > $total ? $total : $to,
      'data'         => $data,
    ];

    if ($page - 1 > 0) {
      $result['prev_page_url'] = "$url?sort=$sort&page=" . ($page - 1) . "&per_page=$perPage";
    }

    if ($page < $last) {
      $result['next_page_url'] = "$url?sort=$sort&page=" . ($page + 1) . "&per_page=$perPage";
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

  public function readFile(string $fileName) {
    return file_get_contents($fileName);
  }

  public function writeFile(string $content, string $fileName) {
    return file_put_contents($fileName, $content);
  }

  public function uploadFile(string $fileName) {
    return move_uploaded_file($_FILES['file']["tmp_name"], $fileName);
  }
}