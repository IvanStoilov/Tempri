<?php

require "classes/firebase.php";
require "classes/ovh-temperature.php";

$currentTemperature = OvhTemperature::getCurrentTemperature();

echo "Current temperature is: {$currentTemperature}°C\n";

Firebase::writeTemp(doubleval($currentTemperature));
