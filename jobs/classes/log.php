<?php

require_once dirname(__FILE__) . "/config.php";

class Log {
  public static function write($message) {
    $date = date('[Y-m-d H:i:s] ');
    $log = $date . $message . "\n";

    echo $log;

    file_put_contents(Config::LOG_FILE, $log, FILE_APPEND);
  }
}
