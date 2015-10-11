<?php

class OvhTemperature {
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
