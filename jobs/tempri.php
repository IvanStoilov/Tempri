<?php

require "classes/firebase.php";
require "classes/ovh-temperature.php";
require "classes/sensors.php";

class Tempri {
  public function run() {
    $data = Firebase::getData();

    $requiredTemp = $this->getRequiredTemperature($data);
    $currentTemp = OvhTemperature::getCurrentTemperature();

    if ($currentTemp > $requiredTemp + $data['upperBound']) {
      Sensors::turnHeatingOff();
    } elseif ($currentTemp < $requiredTemp + $data['lowerBound']) {
      Sensors::turnHeatingOn();
    } else {
      Sensors::turnHeatingOff();
    }
  }

  public function getRequiredTemperature($data) {
    if ($this->hasActiveProgram($data['programs'])) {
      return $data['programTemp'];
    }

    return $data['defaultTemp'];
  }

  public function hasActiveProgram($programs) {
    $currentTime = date('H') * 60 + date('i');

    foreach ($programs as $program) {
      if ($program['from'] <= $currentTime && $currentTime <= $program['to']) {
        return true;
      }
    }

    return false;
  }
}

$tempri = new Tempri();
$tempri->run();
