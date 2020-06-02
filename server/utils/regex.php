<?php
namespace KonKon;

require_once __DIR__ . '/vendor.php';

class Regex {
  private static $__instance = null;

  private function __construct() {}

  public static function getInstance(): Regex {
    if (is_null(self::$__instance)) {
      self::$__instance = new Regex();
    }
    return self::$__instance;
  }

  public function test(string $pattern, string $length, string $subject): bool {
    return preg_match('/' . getenv("regex_$pattern") . '/', $subject) && strlen($subject) <= (int)getenv("regex_length_$length");
  }
}
