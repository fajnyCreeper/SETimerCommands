<?php
ini_set('html_errors', false);
header("Content-Type: text/plain; charset=utf-8");

require_once("vendor/autoload.php");
require_once("config.php");
require_once("StreamElements.php");
require_once("Timer.php");

if (isset($_GET["key"], $_GET["action"], $_GET["params"]) && $_GET["key"] == $key)
{
  $timer = new Timer($bearer, "Bearer");

  $action = $_GET["action"];
  $params = explode(" ", $_GET["params"]);
  $params = str_replace("_", " ", $params);

  switch ($action)
  {
    case "create":
      if (count($params) >= 5)
      {
        $timer->createTimer($params);
        echo "Timer created.";
      }
      else
        echo "Invalid format. Expected !timer create <Name> <OnlineInterval> <OfflineInterval> <ChatLines> <Message1> ...";
      break;

    case "update":
      if (count($params) >= 5)
      {
        $timer->updateTimer($params);
        echo "Timer updated.";
      }
      else
        echo "Invalid format. Expected !timer update <Name> <OnlineInterval> <OfflineInterval> <ChatLines> <Message1> ...";
      break;

    case "enable":
      if (count($params) >= 1)
      {
        $timer->toggleTimer($params[0], true);
        echo "Timer enabled.";
      }
      else
        echo "Invalid format. Expected !timer enable <Name>";
      break;

    case "disable":
      if (count($params) >= 1)
      {
        $timer->toggleTimer($params[0], false);
        echo "Timer disabled.";
      }
      else
        echo "Invalid format. Expected !timer disable <Name>";
      break;

    case "delete":
      if (count($params) >= 1)
      {
        $timer->deleteTimer($params[0]);
        echo "Timer deleted.";
      }
      else
        echo "Invalid format. Expected !timer delete <Name>";
        break;

      case "print":
        if (count($params) >= 1)
        {
          echo $timer->toString($params[0]);
        }
        break;
  }
}

/*
main.php?key=&action=${1}&params=${2:|''}
create Timer_name intervalOnline(minutes) intervalOffline(minutes) chatLines Timer_message_1 Timer_message_2 ...
update Timer_name intervalOnline(minutes) intervalOffline(minutes) chatLines Timer_message_1 Timer_message_2 ...
enable Timer_name
disable Timer_name
delete Timer_name
*/
