<?php

class Firebase {
  private static $url = "https://flickering-fire-163.firebaseio.com/instances/IRINA.json";

  public static function getData() {
    $s = curl_init();

    curl_setopt($s, CURLOPT_URL, self::$url);
    curl_setopt($s,CURLOPT_RETURNTRANSFER,true);

    $response = curl_exec($s);

    curl_close($s);

    return json_decode($response, true);
  }
}

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

class Temperature {
  public static function getCurrentTemperature() {
    /* connect to gmail */
    // /novalidate-cert

    $hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';
    $username = 'tempri.stat@gmail.com';
    $password = 'adminlap16';

    /* try to connect */
    $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

    /* grab emails */
    $query = 'SINCE ' . date('d-M-Y', time());
    $emails = imap_search($inbox, $query);

    /* if emails are returned, cycle through each... */
    if($emails) {

    	/* put the newest emails on top */
    	rsort($emails);

    	/* for every email... */
    	$message = imap_fetchbody($inbox, $emails[0], 1);

      $result = preg_match_all("((\d\d\d\d/\d\d/\d\d \d[\d]?:\d\d:\d\d (AM|PM)) : ([\d]+\.[\d]*))", $message, $matches);

      if ($result) {
        $stats = array();

        for ($i = 0; $i < count($matches[0]); $i++) {
          $temperature = $matches[3][$i];
          $date = $matches[1][$i];
          $stats[$date] = $temperature;
        }

        ksort($stats);

        return end($stats);
      }
    }

    /* close the connection */
    imap_close($inbox);

    return NULL;
  }
}

class Tempri {
  public function run() {
    $data = Firebase::getData();

    $requiredTemp = $this->getRequiredTemperature($data);
    $currentTemp = Temperature::getCurrentTemperature();

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
