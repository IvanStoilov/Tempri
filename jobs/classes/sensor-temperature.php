<?php

class SensorTemperature {
  public static function getCurrentTemperature() {
    $data = file_get_contents('/sys/bus/w1/devices/28-01158278daff/w1_slave');

    list($rest, $temp) = explode('=', $data);

    return $temp;
  }
}
