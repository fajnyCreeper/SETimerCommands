<?php
ini_set('html_errors', false);
header("Content-Type: text/plain; charset=utf-8");

require_once("vendor/autoload.php");
require_once("config.php");
require_once("StreamElements.php");
require_once("Timer.php");

if (isset($_GET["key"], $_GET["action"], $_GET["params"]) && $_GET["key"] == $key)
{
  $timer = new Timer($bearer, "Bearer", $baseUrl, $key);

  $action = $_GET["action"];
  $params = explode(" ", $_GET["params"]);
  $params = str_replace("_", " ", $params);

  switch ($action)
  {
    case "create":
      if (count($params) >= 5)
      {
        $res = $timer->createTimer($params);
        if (array_key_exists("error", $res))
          echo $res["error"];
        else
          echo "Timer \"".$params[0]."\" created.";
      }
      else
        echo "Invalid format. Expected !timer create <Name> <OnlineInterval> <OfflineInterval> <ChatLines> <Message1> ...";
      break;

    case "update":
      if (count($params) >= 5)
      {
        $res = $timer->updateTimer($params);
        if ($res === null)
          echo "Could not find timer called \"".$params[0]."\".";
        else
          echo "Timer \"".$params[0]."\" updated.";
      }
      else
        echo "Invalid format. Expected !timer update <Name> <OnlineInterval> <OfflineInterval> <ChatLines> <Message1> ...";
      break;

    case "enable":
      if (count($params) >= 1)
      {
        $res = $timer->toggleTimer($params[0], true);
        if ($res === null)
          echo "Could not find timer called \"".$params[0]."\".";
        else
          echo "Timer \"".$params[0]."\" enabled.";
      }
      else
        echo "Invalid format. Expected !timer enable <Name>";
      break;

    case "disable":
      if (count($params) >= 1)
      {
        $res = $timer->toggleTimer($params[0], false);
        if ($res === null)
          echo "Could not find timer called \"".$params[0]."\".";
        else
          echo "Timer \"".$params[0]."\" disabled.";
      }
      else
        echo "Invalid format. Expected !timer disable <Name>";
      break;

    case "delete":
      if (count($params) >= 1)
      {
        $res = $timer->deleteTimer($params[0]);
        if ($res === null)
          echo "Could not find timer called \"".$params[0]."\".";
        else
          echo "Timer \"".$params[0]."\" deleted.";
      }
      else
        echo "Invalid format. Expected !timer delete <Name>";
        break;

      case "print":
        if (count($params) >= 1)
        {
          $res = $timer->toString($params[0]);
          if ($res == "")
            echo "Could not find timer called \"".$params[0]."\".";
          else
            echo $res;
        }
        else
          echo "Invalid format. Expected !timer print Timer_name";
        break;

      case "list":
        echo $timer->listTimers();
        break;

      case "bind":
        if (count($params) >= 2)
        {
          $res = $timer->bindCommand($params[0], $params[1]);
          if ($res === null)
            echo "Command or timer with provided name doesn't exist.";
          else
            echo "Command binded.";
        }
        else
          echo "Invalid format. Expected !timer bind Timer_name Command_name";
        break;

      default:
        echo "Invalid action! Expected create|update|enable|disable|delete|print|list|bind";
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
