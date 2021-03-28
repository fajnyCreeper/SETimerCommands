<?php
ini_set('html_errors', false);
header("Content-Type: text/plain; charset=utf-8");

require_once("vendor/autoload.php");
require_once("config.php");
require_once("StreamElements.php");

if (isset($_GET["key"], $_GET["command"]) && $_GET["key"] == $key)
{
  $bot = new StreamElements($bearer, "Bearer");

  $command = $bot->getCommand($_GET["command"]);

  echo $command["reply"];
}
