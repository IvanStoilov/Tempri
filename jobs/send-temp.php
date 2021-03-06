<?php

require_once dirname(__FILE__) . "/classes/firebase.php";
require_once dirname(__FILE__) . "/classes/ovh-temperature.php";
require_once dirname(__FILE__) . "/classes/sensor-temperature.php";

$currentTemperature = SensorTemperature::getCurrentTemperature();

echo "Current temperature is: {$currentTemperature}°C\n";

Firebase::writeTemp(doubleval($currentTemperature));
