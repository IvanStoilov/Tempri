<?php

class Firebase {
  private static $url = "https://flickering-fire-163.firebaseio.com/instances/IRINA";

  public static function getData() {
    $s = curl_init();

    curl_setopt($s, CURLOPT_URL, self::$url . ".json");
    curl_setopt($s, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($s);

    curl_close($s);

    return json_decode($response, true);
  }

  public static function writeTemp($temperature) {
    $s = curl_init();

    curl_setopt($s, CURLOPT_URL, self::$url . "/currentTemp.json");
    curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($s, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($s, CURLOPT_POSTFIELDS, $temperature);

    ////////////////
    // curl_setopt($s, CURLOPT_VERBOSE, true);
    ////////////////

    $response = curl_exec($s);

    curl_close($s);
  }
}
