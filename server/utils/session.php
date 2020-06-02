<?php
namespace KonKon;

class Session {
  private static $__instance = null;

  private function __construct() {}

  public static function getInstance(): Session {
    if (is_null(self::$__instance)) {
      self::$__instance = new Session();
    }
    return self::$__instance;
  }

  public function start($sessionId = null): void {
    session_id($sessionId);
    if (session_status() == PHP_SESSION_NONE) {
      session_start([
        'name' => 'session',
      ]);
    }
  }

  public function isActived(): bool {
    return session_status() == PHP_SESSION_ACTIVE;
  }

  public function getSessionId(): string {
    return session_id();
  }

  public function get(string $key) {
    return $_SESSION[$key];
  }

  function isSet(string $key): bool {
    return isset($_SESSION[$key]);
  }

  public function set(string $key, string $value): void {
    $_SESSION[$key] = $value;
  }

  public function remove(string $key): void {
    unset($_SESSION[$key]);
  }
}
