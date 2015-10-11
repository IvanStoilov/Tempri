<?php

class Sensors {
  public static function turnHeatingOn() {
    echo "Heating on\n";
  }

  public static function turnHeatingOff() {
    echo "Heating off\n";
  }

  public static function isOn() {
    return true;
  }
}
