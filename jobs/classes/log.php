<?php

class Log {
  public static function write($message) {
    $date = date('[Y-m-d H:i:s] ');
    var $log = $date . $message . "\n";

    echo $log;

    file_put_contents(self::$file, $log, FILE_APPEND);
  }
}
