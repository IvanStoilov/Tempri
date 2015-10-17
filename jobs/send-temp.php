<?php

require dirname(__FILE__) . "/classes/firebase.php";
require dirname(__FILE__) . "/classes/ovh-temperature.php";

$currentTemperature = OvhTemperature::getCurrentTemperature();

echo "Current temperature is: {$currentTemperature}°C\n";

Firebase::writeTemp(doubleval($currentTemperature));
