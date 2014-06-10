<?php
set_time_limit(86400);


define("BASE_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR);

function get_base_url()
{
  /* First we need to get the protocol the website is using */
  $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';

  /* returns /myproject/index.php */
  $path = $_SERVER['PHP_SELF'];

  /*
  * returns an array with:
  * Array (
  *  [dirname] => /myproject/
  *  [basename] => index.php
  *  [extension] => php
  *  [filename] => index
  * )
  */
  $path_parts = pathinfo($path);
  $directory = $path_parts['dirname'];
  /*
  * If we are visiting a page off the base URL, the dirname would just be a "/",
  * If it is, we would want to remove this
  */
  $directory = ($directory == "/") ? "" : $directory;

  /* Returns localhost OR mysite.com */
  $host = $_SERVER['HTTP_HOST'];

  /*
  * Returns:
  * http://localhost/mysite
  * OR
  * https://mysite.com
  */
  return $protocol . $host . $directory;
}

require_once('mail_imap.php');
require_once('Encoding.php');
require_once('FileStorage.php');

require_once('parsing_map.php');