<?php

require "./log.php"

class Sensors {
  private static $file = ".status";

  public static function turnHeatingOn() {
    if (self::isOn()) {
      return ;
    }

    self::setStatus(1);

    Log::write("Heating on");
    self::setServo(1700);
  }

  public static function turnHeatingOff() {
    if (!self::isOn()) {
      return ;
    }

    self::setStatus(0);

    Log::write("Heating off");
    self::setServo(1000);
  }

  public static function isOn() {
    $status = file_get_contents(self::$file);
    return $status === "1";
  }

  private static function setServo($frequency) {
    $cmd = dirname(dirname(__FILE__)) . "/servo.py " . $frequency;
    exec('sudo ' . $cmd);
  }

  private static function setStatus($status) {
    file_put_contents(self::$file, $status);
  }
}
