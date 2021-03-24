<?php
header("Content-Type: text/plain; charset=utf-8");

require_once("vendor/autoload.php");
require_once("config.php");
require_once("StreamElements.php");
require_once("create.php");

if (isset($_GET["key"], $_GET["action"], $_GET["params"]) && $_GET["key"] == $key)
{
  $bot = new StreamElements($bearer, "Bearer");
  $action = $_GET["action"];
  $params = explode(" ", $_GET["params"]);

  switch ($action)
  {
    case "create":
      if (count($params) >= 5)
      {
        CreateTimer($bot, $params);
      }
      else
      {
        echo "Invalid format. Expected !timer create <Name> <OnlineInterval> <OfflineInterval> <ChatLines> <Message1> ...";
      }
      break;
  }
}
