<?php

/**
 * Custom Helper
 * Author: Sorav Garg
 * Author Email: soravgarg123@gmail.com
 * version: 1.0
 */

/**
 * [To print array]
 * @param array $arr
 */
if (!function_exists('pr')) {
  function pr($arr)
  {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    die;
  }
}

/**
 * [Create GUID]
 * @return string
 */
if (!function_exists('get_guid')) {
  function get_guid()
  {
    if (function_exists('com_create_guid')) {
      return strtolower(com_create_guid());
    } else {
      mt_srand((float) microtime() * 10000); //optional for php 4.2.0 and up.
      $charid = strtoupper(md5(uniqid(rand(), true)));
      $hyphen = chr(45); // "-"
      $uuid = substr($charid, 0, 8) . $hyphen
        . substr($charid, 8, 4) . $hyphen
        . substr($charid, 12, 4) . $hyphen
        . substr($charid, 16, 4) . $hyphen
        . substr($charid, 20, 12);
      return strtolower($uuid);
    }
  }
}

/**
 * [To check if site has SSL]
 */
if (!function_exists('isSSL')) {
  function isSSL()
  {
    if (isset($_SERVER['HTTPS'])) {
      return 'https';
    } else {
      return 'http';
    }
  }
}

/**
 * [To print number in standard format with 0 prefix]
 * @param int $no
 */
if (!function_exists('addZero')) {
  function addZero($no)
  {
    if ($no >= 10) {
      return $no;
    } else {
      return "0" . $no;
    }
  }
}

/**
 * [To convert date time format]
 * @param datetime $datetime
 * @param string $format
 */
if (!function_exists('convertDateTime')) {
  function convertDateTime($datetime, $format = 'dS F Y, h:i A')
  {
    if (empty($datetime)) return "N/A";
    $convertedDateTime = date($format, strtotime($datetime));
    return $convertedDateTime;
  }
}
