<?php

class SensorTemperature {
  public static function getCurrentTemperature() {
    $data = file_get_contents('/sys/bus/w1/devices/28-01158278daff/w1_slave');

    list($rest, $temp) = explode('t=', $data);

    $temp = intval($temp) / 1000;

    return $temp;
  }
}
